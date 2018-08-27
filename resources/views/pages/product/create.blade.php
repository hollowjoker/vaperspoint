@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3>Products</h3>
                        <span class="text-muted">Add of your Products</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card my-2">
			<div class="card-body">
                <form action=" {{ route('product.store') }} " class="needs-validation" novalidate>
                    {{ csrf_field() }}
                    <table class="table table-borderless table-hover table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Category</th>
                                <th>Item Name</th>
                                <th>Description</th>
                                <th>Size</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Srp_Price</th>
                                <th>Amount</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> <button type="button" class="btn btn-danger btn-sm delLine"><i class="fa fa-minus" aria-hidden="true"></i></button> </td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control form-control-sm" name="tbl_category_id[]" required>
                                            <option selected disabled value="">&dash;</option>
                                            @foreach($category as $each)
                                                <option value="{{ $each['id'] }}"> {{ $each['category_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td> <input class="form-control form-control-sm" type="text" name="item_name[]" placeholder="Item Name" required> </td>
                                <td> <textarea class="form-control form-control-sm" type="text" name="description[]" placeholder="Description"></textarea> </td>
                                <td> <input class="form-control form-control-sm" type="text" name="size[]" placeholder="Size"> </td>
                                <td> <input class="form-control form-control-sm compute" type="text" name="qty[]" placeholder="Qty" required> </td>
                                <td> <input class="form-control form-control-sm compute" type="text" name="price[]" placeholder="Price" required> </td>
                                <td> <input class="form-control form-control-sm" type="text" name="srp_price[]" placeholder="Srp" required> </td>
                                <td> <input class="form-control form-control-sm compute" type="text" name="amount[]" readonly placeholder="Amount" required> </td>
                                <td> <button type="button" class="btn btn-info btn-sm addLine"><i class="fa fa-plus" aria-hidden="true"></i></button> </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" Placeholder="Submit" class="btn btn-info mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>

@stop

@section('pageJs')
    <script>
        $(function(){
            $('#sidenavToggler').click();

            addLine();
            compute();
            delLine();

            $('form').submit(function(){
                var thisForm = $(this);
                var thisUrl = thisForm.attr('action');
                var formData = thisForm.serialize();

                $.ajax({
                    url : thisUrl,
                    data : formData,
                    type : 'post'
                }).done(function(returnData){

                    console.log(returnData);
                    if(returnData['type'] == 'success'){
                        swal('Good Job!',returnData['message'],returnData['type'],{
							button: "Aww yiss!",
						}).then((value) =>  {
                            window.location = ' {{ route("product") }} ';
                        });
                    }
                    else{ 
                        thisForm.addClass('was-validated');
                    }
                });
                return false;
            });

            
        });


        function addLine(){
            $('.addLine').unbind('click');
            $('.addLine').bind('click',function(){
                $.ajax({
                    url : '/product/create/add',
                    type : 'get'
                }).done(function(returnData){
                    $('table tbody').append(returnData);
                    addLine();
                    compute();
                    delLine();
                });

            });
        }

        function delLine(){
            $('.delLine').unbind('click');
            $('.delLine').bind('click',function(){
                var length = $('table tbody').find('tr').length;
                if(length > 1){
                    $(this).closest('tr').remove();
                }
            });
        }

        function compute(){
            $('.compute').unbind('keyup');
            $('.compute').bind('keyup blur',function(){
                var tr = $(this).closest('tr');
                var totalAmount = checkNumeric(parseInt(tr.find('[name="amount"]').val()));
                var qty = checkNumeric(parseInt(tr.find('[name="qty[]"]').val()));
                var price = checkNumeric(parseInt(tr.find('[name="price[]"]').val()));
                totalAmount += qty * price;
                tr.find('[name="amount[]"]').val(totalAmount);
            });
        }
    </script>
@stop