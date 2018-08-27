@extends('layout.master')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3>List of Products</h3>
                                <span class="text-muted">This list is showing all Category of your Items</span>
                            </div>
                            <div class="col-sm-4 text-right">
                                <a href="{{ route('product.create') }}" class="btn btn-info btn-lg">Add Product</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                        
        <div class="card my-2">
            <div class="card-body">
                <table class="table table-borderless table-hover table-striped" id="productTable">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Item Name</th>
                            <th>Description</th>
                            <th>Size</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Srp_Price</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="importModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form action="{{ route('product.update') }}" id="importForm" method="post" class="needs-validation" novalidate>
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
					<div class="modal-header">
						<h5 class="modal-title">Import Product</h5>
						<button class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group has-danger">
							<label for="qty">Qty</label>
							<input type="text" name="qty" id="qty" class="form-control" required >
							<input type="hidden" name="id" class="form-control" >
						</div>
						<div class="form-group">
							<label for="price">Price</label>
							<input name="price" id="price" class="form-control" readonly>
						</div>
						<div class="form-group">
							<label for="srp_price">Srp Price</label>
							<input type="text" name="srp_price" id="srp_price" class="form-control" readonly>
                        </div>
                        <div class="form-group">
							<label for="amount">Amount</label>
							<input type="text" name="amount" id="amount" class="form-control" readonly>
						</div>
					</div>
					<div class="modal-footer text-right">
						<button class="btn btn-info" type="submit">
							Submit Import
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@stop

@section('pageJs')
    <script>
        $('.modal').on('hide.bs.modal', function () {
			getData();
		});
        $(function(){
            getData();
            $('#importForm').unbind('submit');
            $('#importForm').bind('submit',function(){
                var thisForm = $(this);
                $.ajax({
                    url : $(this).attr('action'),
                    type : 'PATCH',
                    data : $(this).serialize()
                }).done(function(result){

                    if(result['type'] == 'success'){
                        removeValidation(thisForm);
                        $('#importModal').modal('hide');
                        swal('Good Job!',result['message'],result['type'],{
                            button: "Aww yiss!",
                        });
                    }
                    else{
                        applyValidation(thisForm,result['message']);
                    }
                });
                return false;
            });

            $('#importForm [name="qty"]').unbind('keyup');
            $('#importForm [name="qty"]').bind('keyup',function(){
                compute();
            });
        });

        function getData() {
            $('#productTable').DataTable({
                processing : true,
                destroy : true,
                serverSide : true,
                responsive : true,
                searching : true,
                autoWidth : false,
                ajax : {
                    url : '/product/api'
                }
            });
        }
        
        function getProduct(id) {
            $.ajax({
                url : ' {!! url("/product/getProduct/'+id+'") !!} ',
                type : 'get',

            }).done(function(r){
                var thisForm = $('#importForm');
                $.each(r[0],function(key,value){
                    thisForm.find('[name="'+key+'"]').val(value);
                });
                compute();
            });
        }

        function compute() {
            var thisForm = $('#importForm');
            var qty = checkNumeric(parseInt(thisForm.find('[name="qty"]').val()));
            var price = checkNumeric(parseInt(thisForm.find('[name="price"]').val()));

            var amount = (qty * price).toFixed(2);
            $('[name="amount"]').val(amount);
        }
    </script>
@stop