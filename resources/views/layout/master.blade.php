<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{!! asset('css/app.css') !!}">
        <!-- <link rel="stylesheet" href="{!! asset('sbadmin/vendor/bootstrap/css/bootstrap.min.css') !!}" > -->
        <link rel="stylesheet" href="{!! asset('sbadmin/vendor/font-awesome/css/font-awesome.min.css')!!}" >
        <link rel="stylesheet" href="{!! asset('sbadmin/vendor/datatables/dataTables.bootstrap4.css')!!}" >
        <link rel="stylesheet" href="{!! asset('sbadmin/css/sb-admin.min.css') !!}">
        <link rel="stylesheet" href="{!! asset('css/material-bootstrap-datepicker.css') !!}">
        <link rel="stylesheet" href="{!! asset('css/style-me.css') !!}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/twinlincoln_icon.png') }}" />
        <title>Twinlincoln</title>
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body class="fixed-nav bg-dark" id="page-top">
        @include('layout.header')
        {{-- @yield('content') --}}
    </body>

    <script src="{!! asset('js/app.js') !!}"></script>

    <!-- <script src="{!! asset('sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') !!}"></script> -->
    <script src="{!! asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js') !!}"></script>
    <script src="{!! asset('js/moment.js') !!}"></script>
    <script src="{!! asset('js/material-bootstrap-datetimepicker.js') !!}"></script>
    <script src="{!! asset('sbadmin/vendor/chart.js/Chart.min.js') !!}"></script>
    <script src="{!! asset('sbadmin/vendor/datatables/jquery.dataTables.js') !!}"></script>
    <script src="{!! asset('sbadmin/vendor/datatables/dataTables.bootstrap4.js') !!}"></script>
    <script src="{!! asset('sbadmin/js/sb-admin.min.js') !!}"></script>
    <script src="{!! asset('sbadmin/js/sb-admin-datatables.min.js') !!}"></script>
    <script src="{!! asset('js/sweetalert.js') !!}"></script>
    <script src="{!! asset('js/numeral.min.js') !!}"></script>
    <script src="{!! asset('js/js-me.js') !!}"></script>

    @yield('pageJs')
</html>
