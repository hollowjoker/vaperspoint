<?php $a = URL::current(); ?>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top" id="mainNav">
    <a href="" class="navbar-brand">
        <i class="fa fa-motorcycle" aria-hidden="true"></i>
        TwinLincoln
    </a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive"  aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
            <li class="nav-item <?= (strpos($a, 'dashboard') ? 'active' : '') ?>" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fa fa-fw fa-dashboard"></i>
                    <span class="nav-link-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item <?= (strpos($a, 'transaction') ? 'active' : '') ?>" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <a class="nav-link" href="{{ route('transaction') }}">
                    <i class="fa fa-fw fa-dashboard"></i>
                    <span class="nav-link-text">Transaction</span>
                </a>
            </li>
            <li class="nav-item <?= (strpos($a, 'product') ? 'active' : '') ?>" data-toggle="tooltip" data-placement="right" title="Product">
                <!-- <a class="nav-link nav-link-collapse collapsed" href="{{ route('product') }} #collapseComponents" data-toggle="collapse" data-parent="#exampleAccordion"> -->
                <a class="nav-link nav-link-collapse collapsed" href="#collapseComponents" data-toggle="collapse" data-parent="#exampleAccordion">
                    <i class="fa fa-fw fa-plus-square"></i>
                    <span class="nav-link-text">Product</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseComponents">
                    <li>
                        <a href="{{ route('product') }}">List Product</a>
                    </li>
                    <li>
                        <a href="{{ route('product.create') }}">Add Product</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item <?= (strpos($a, 'inventory') ? 'active' : '') ?>" data-toggle="tooltip" data-placement="right" title="Inventory">
                <a class="nav-link" href="{{ route('inventory') }}">
                    <i class="fa fa-fw fa-cubes"></i>
                    <span class="nav-link-text">Inventory</span>
                </a>
            </li>
            <li class="nav-item <?= (strpos($a, 'category') ? 'active' : '') ?>" data-toggle="tooltip" data-placement="right" title="Category">
                <a class="nav-link" href="{{ route('category') }} ">
                    <i class="fa fa-fw fa-plus-square"></i>
                    <span class="nav-link-text">Category</span>
                </a>
            </li>
            <li class="nav-item <?= (strpos($a, 'expense') ? 'active' : '') ?>" data-toggle="tooltip" data-placement="right" title="Expense">
                <a class="nav-link" href="{{ route('expense') }} ">
                    <!-- <i class="fa fa-fw fa-plus-square"></i> -->
                    <i class="fa fa-fw fa-money"></i>
                    <span class="nav-link-text">Expense</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="#" class="nav-link openTimein">
                    <i class="fa fa-clock-o"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa fa-shopping-cart"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ date('a') == 'am' ? 'Good Morning' : 'Good Evening' }} Admin!
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
                    <a class="dropdown-item" href=" {{ route('login.logout') }} ">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<div class="content-wrapper">
    @yield('content')
</div>


<!-- modal -->
<div class="modal fade" id="timeInModal" tabindex="-1" role="dialog" aria-labelledby="timeInModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="timeInModalLabel">Time In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('dashboard.attendance_save')}}" class="text-center">
                            <h3> {{ date('F d, Y') }} </h3>
                            <h1 class="display-4 mb-5"> {{ date('H:i A') }} </h1>
                            <div class="form-group text-left">
                                <label for="worker">Worker</label>
                                <select name="" id="worker" class="form-control"></select>
                                <input type="hidden" class="form-control" name="" id="attendance" value="{{ date('H:i a') }}"> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

@section('pageJs')
    <!-- <script>
        $(function(){
            $('.openTimein').on('click',function(){
                $('#timeInModal').modal();
            });
        });
    </script> -->
@stop