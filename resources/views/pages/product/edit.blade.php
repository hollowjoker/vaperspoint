@extends('layout.master')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card mb-5">
                <div class="card-body">
                    <h2>Edit Product</h2>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('product.updateAll') }}" method="post" class="needs-validation" novalidate>
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <div class="form-group">
                                    <label for="tbl_category_id">Category</label>
                                    <select name="tbl_category_id" id="tbl_category_id" class="form-control">
                                        @if($category != '')
                                            @foreach($category as $each)
                                                <option value="{{ $each['id'] }}" {{ $product['tbl_category_id'] == $each['id'] ? 'selected' : '' }}> {{ $each['category_name'] }} </option>
                                            @endforeach
                                        @endif
                                    </select>
							        <input type="hidden" name="id" class="form-control" value="{{ $product['id'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="item_name">Item Name</label>
                                    <input name="item_name" id="item_name" type="text" Placeholder="Item Name" class="form-control"  value="{{ $product['item_name'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control">{{ $product['description'] }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="size">Size</label>
                                    <input name="size" id="size" type="text" Placeholder="Size" class="form-control"  value="{{ $product['size'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="qty">Qty</label>
                                    <input name="qty" id="size" type="text" Placeholder="Size" class="form-control"  value="{{ $product['qty'] }}" readonly >
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input name="price" id="price" type="text" Placeholder="Price" class="form-control"  value="{{ $product['price'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="srp_price">Srp Price</label>
                                    <input name="srp_price" id="srp_price" type="text" Placeholder="Srp Price" class="form-control"  value="{{ $product['srp_price'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input name="amount" id="amount" type="text" Placeholder="Amount" class="form-control" readonly>
                                </div>
                                <button type="submit" Placeholder="Submit" class="btn btn-info mt-3">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop


@section('pageJs')
    <script>
        $(function(){
            compute();

            $('[name="price"]').unbind('keyup');
            $('[name="price"]').bind('keyup',function(){
                compute();
            });

            $('form').unbind('submit');
            $('form').bind('submit',function() {
                var thisForm = $(this);

                $.ajax({
                    url : thisForm.attr('action'),
                    type : 'PATCH',
                    data : thisForm.serialize()
                }).done(function(result){
                    console.log(result);
                    if(result['type'] == 'success'){
                        removeValidation(thisForm);
                        swal('Good Job!', result['message'], result['type'],{
                            button: 'Aww yiss!',
                        }).then((value) => {
                            location.href = '/product';
                        });
                    }
                    else{
                        applyValidation(thisForm,result['message']);
                    }
                });
                return false;
            });

        });

        function compute() {
            var qty = checkNumeric(parseInt($('[name="qty"]').val()));
            var price = checkNumeric(parseInt($('[name="price"]').val()));
            var amount = (qty * price).toFixed(2);

            $('[name="amount"]').val(amount);
        }
    </script>
@stop