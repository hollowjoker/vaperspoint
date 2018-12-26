@extends('layout.master')
@section('content')


<section class="product-listing">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body main-bg-color d-flex">
                        <div>
                            <h1>List of Products</h1>
                            <p>This list are showing all Category of your items.</p>
                        </div>

                        <div class="card-body-add-product">
                            <div class="btn btn-md btn-dark-color text-white" data-toggle="modal" data-target="#addProduct">Add Product</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="productHolder" data-url="{{ route('products.show') }}" ></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="addItemForm" data-url="{{ route('products.add_form') }}"></div>
            </div>
        </div>
    </div>
</section>

@stop

@section('pageJs')
    <script>
        $(function(){
            getData();
            getAddForm();
        });

        function getData() {
            var that = $('#productHolder');
            var dataUrl = that.attr('data-url');

            $.ajax({
                url : dataUrl,
                data : '',
            }).done(function(returnData){
                that.html(returnData);
            });
        }

        function getAddForm() {
            var that = $('#addItemForm');
            var dataUrl = that.attr('data-url');
            
            $.ajax({
                url : dataUrl,
                data : '',
            }).done(function(returnData){
                console.log(returnData);
                that.html(returnData);
            });
        }
    </script>
@stop