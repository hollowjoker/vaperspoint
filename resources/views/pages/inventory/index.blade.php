@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h3>Inventory</h3>
                            <span class="text-muted">This list is showing all of your Items</span>
                    </div>
                </div>
                <div class="card my-2">
                    <div class="card-body">
                        <table class="table table-borderless table-hover table-striped" id="inventoryTable">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Category</th>
                                    <th>Size</th>
                                    <th>Qty</th>
                                    <th>Srp_Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h3>Cart</h3>
                        <span class="text-muted">This is your Customer Cart</span>
                    </div>
                </div>
                <div class="card my-2 py-3">
                    <div class="card-body">
                        <form action="{{ route('inventory.store')}}" method="post" id="inventoryStoreForm" class="customerCartTable" novalidate>
                            {{ csrf_field() }}
                            <table id="customerCartTable" class="table table-bordered table-striped table-heading">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <h4>Total: <span id="grandTotal">0</span> </h4>
                            <hr>
                            <div class="form-group">
                                <label for="customer_name">Sold To:</label>
                                <input type="text" name="customer_name" id="customer_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <textarea name="address" id="address" class="form-control"></textarea>
                            </div>
                            <div class="form-group my-3">
                                <label for="worker_id">Your Worker</label>
                                <select name="worker_id" id="worker_id" class="form-control">
                                    @foreach($userData as $each)
                                        <option value="{{ $each['id'] }}"> {{ $each['user_name'] }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">Checkout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addcartModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form action="" id="addCartForm" method="post" class="needs-validation" novalidate>
					{{ csrf_field() }}
					<div class="modal-header">
						<h5 class="modal-title">Add to Cart</h5>
						<button class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="qty">Quantity</label>
							<input type="text" name="qty" id="qty" class="form-control" required placeholder="0">
                            <input type="hidden" name="id" class="form-control" >
                            <div class="invalid-feedback-custom"></div>
						</div>
					</div>
					<div class="modal-footer text-right">
						<button class="btn btn-info" type="submit" disabled>
							Send to Cart
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@stop

@section('pageJs')
    <script>
        var items = [];
        $(function(){

            $('#addcartModal').on('hide.bs.modal', function () {
                var thisForm = $('#addCartForm');
			    thisForm[0].reset();
                thisForm.find('[name="id"]').val('');
                thisForm.attr('data-price',0);
                thisForm.attr('data-item-name','');
				// getData();
            });
            
            $('#sidenavToggler').click();
            getData();
            getCart();
            
            $('#addCartForm').unbind('submit');
            $('#addCartForm').bind('submit', function(){
                
                var thisForm = $(this);
                var customerTable = $('#customerCartTable');
                var qty = thisForm.find('[name="qty"]').val();
                var id = thisForm.find('[name="id"]').val();
                var price = thisForm.attr('data-price');
                var item_name = thisForm.attr('data-item-name');
                var amount = parseInt(qty) * parseInt(price);
                var customerToAppend = 
                                        '<tr class="for-cart">'+
                                            '<td>'+item_name+'</td>'+
                                            '<td>'+qty+'</td>'+
                                            '<td>'+price+'</td>'+
                                            '<td class="to-rel">'+amount+
                                                '<button type="button" class="custom-delete btn btn-danger btn-sm delLine"><i class="fa fa-minus"></i></button>'+
                                                '<input type="hidden" name="id[]" value="'+id+'">'+
                                                '<input type="hidden" name="qty[]" value="'+qty+'">'+
                                                '<input type="hidden" name="price[]" value="'+price+'">'+
                                                '<input type="hidden" name="amount[]" value="'+amount+'">'+
                                            '</td>'+
                                        '</tr>';
                
                customerTable.find('tbody').append(customerToAppend);
                computeGrand();
                $('#addcartModal').modal('hide');
                storeToLocal();
                delLine();
                return false;
            });

            $('#inventoryStoreForm').unbind('submit');
            $('#inventoryStoreForm').bind('submit',function(){
                var thisForm = $(this);

                swal("Checking Out","Please type your password:","info", {
                    content : {
                        element : 'input',
                        attributes: {
                            type: 'password'
                        }
                    },
                    
                })
                .then((value) => {
                    $.ajax({
                        url : '/inventory/store/api',
                        type : 'POST',
                        data : thisForm.serialize()+'&user_password='+value,
                    }).done(function(result){
                        if(result['type'] == 'success'){
                            userId = result['message'];

                            $.ajax({
                                url : thisForm.attr('action'),
                                data : thisForm.serialize()+'&user_id='+userId,
                                type : 'post'
                            }).done(function(returnData){
                                console.log(returnData);
                                if(returnData['type'] == 'error'){
								    applyValidation(thisForm,returnData['message']);
                                    swal('OH NO!',"Something went wrong try again.",returnData['type'],{
                                        button: "Aww yiss!",
                                    });
                                }
                                else{
								    removeValidation(thisForm);
                                    swal('Good Job!',returnData['message'],returnData['type'],{
                                        button: "Aww yiss!",
                                    }).then( (value) => {
                                        window.location.href = '{!! URL::to("inventory/receipt/'+returnData['code']+'") !!}';
                                    });
                                }
                            });
                        }
                        else{
                            swal('Oh Noez!','Your password is Invalid',result['type'],{
                                button : "Ok"
                            })
                            .then((value) => {
                                $('#expenseModal').modal('show');
                            });
                        }
                    });
                });
                return false;
            });
        });
        
        function getData() {
            $('#inventoryTable').DataTable({
                processing : true,
                destroy : true,
                serverSide : true,
                responsive : true,
                searching : true,
                autoWidth : false,
                ajax : {
                    url : '/inventory/api'
                },
                createdRow: function(row, data, index) {
                    var thisRow = $(row);

                    if(data[3] == 0){
                        thisRow.addClass('table-danger');
                    }
                },
            });
        }

        function addToCart(that,id,qty,srp_price) {
            var thisForm = $('#addCartForm');
            $('#addcartModal').modal();
            thisForm.find('[name="id"]').val(id);
            thisForm.find('[name="qty"]').attr('max-qty',qty);
            thisForm.attr('data-item-name',$(that).attr('data-item'));
            thisForm.attr('data-price',srp_price);
            putQty();
        }

        function putQty() {
            var thisForm = $('#addCartForm');

            $(thisForm).find('[name="qty"]').unbind('keyup');
            $(thisForm).find('[name="qty"]').bind('keyup',function(){
                var maxQty = $(this).attr('max-qty');
                if(parseInt($(this).val()) <= parseInt(maxQty)){
                    thisForm.find('[type="submit"]').attr('disabled',false);
                    if(parseInt($(this).val()) == 0){
                        thisForm.find('[type="submit"]').attr('disabled',true);
                    }
                    thisForm.find('.invalid-feedback-custom').closest('.form-group').removeClass('has-danger-custom');
                }
                else{
                    thisForm.find('.invalid-feedback-custom').closest('.form-group').addClass('has-danger-custom');
                    thisForm.find('.invalid-feedback-custom').text('Your item has only '+maxQty+' in your Inventory. Please put lower than your inventory');
                    thisForm.find('[type="submit"]').attr('disabled',true);
                }
            });
        }

        function view(id) {
            alert(id);
        }

        function computeGrand() {
            var grand = 0;
            var thisTable = $('#customerCartTable');
            thisTable.find('tbody tr').each(function(){
                grand += parseInt(numeral($(this).find('td:last-child').text()).value());
            });
            $('#grandTotal').text(numberFormat(grand));

        }
        
        function storeToLocal(){
            var thisTable = $('#customerCartTable');
            var toLocal = [];
            var arr = {};
            $.each(thisTable.find('tbody tr'), function(key,value){
                var thisTr = $(this);

                arr[key] = {
                    id: thisTr.find('[name="id[]"]').val(),
                    item_name: thisTr.find('td:first-child').text(),
                    qty: thisTr.find('[name="qty[]"]').val(),
                    price: thisTr.find('[name="price[]"]').val(),
                    amount: thisTr.find('[name="amount[]"]').val(),
                }

            });

            computeGrand();
            localStorage.setItem('cart', JSON.stringify(arr));
        }

        function delLine() {
            $('.delLine').unbind('click');
            $('.delLine').bind('click',function(){
                var that = $(this);
                swal("Warning","Are you sure you want to do this?","warning",{
                    buttons: ["Oh noez!", "Aww yiss!"],
                }).then((value) =>{
                    if(value){
                        that.closest('tr').remove();
                        storeToLocal();
                    }
                });
            });
        }

        function getCart() {
            var cart = localStorage.getItem('cart');
            var cartBody = $('#customerCartTable').find('tbody');
            var customerToAppend = '';
            $.each($.parseJSON(cart), function(key, value){
                customerToAppend += 
                                    '<tr class="for-cart">'+
                                        '<td>'+value['item_name']+'</td>'+
                                        '<td>'+value['qty']+'</td>'+
                                        '<td>'+numberFormat(value['price'])+'</td>'+
                                        '<td class="to-rel">'+numberFormat(value['amount'])+
                                            '<button type="button" class="custom-delete btn btn-danger btn-sm delLine"><i class="fa fa-minus"></i></button>'+
                                            '<input type="hidden" name="id[]" value="'+value['id']+'">'+
                                            '<input type="hidden" name="qty[]" value="'+value['qty']+'">'+
                                            '<input type="hidden" name="price[]" value="'+value['price']+'">'+
                                            '<input type="hidden" name="amount[]" value="'+value['amount']+'">'+
                                        '</td>'+
                                    '</tr>';
            });
            cartBody.html(customerToAppend);
            computeGrand();
            delLine();
        }

    </script>
@stop