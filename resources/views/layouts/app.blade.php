<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">   

    <link rel="stylesheet" href="{{asset('css/materializev1.0.0/materialize.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/materialize.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/PRRC.css')}}">

    <link href="{{asset('fonts/materialIcons.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="{{asset('js/jquery.js')}}"></script>

    <!-- DataTables -->
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <title>{{config('app.name')}}</title>
    <style>
    table.dataTable thead th {padding: 10px 18px; border-bottom: 2px solid #64b5f6 !important; }
    table.dataTable table {padding: 10px 18px 6px 18px; border-bottom: : 1px solid #64b5f6 !important; }
    form.search-on-nav {margin-left: 300px; margin-right:300px;}
    .dataTables_paginate {float: left;} .dataTables_paginate .paginate_button {transition: 0.25s; height: 42px; } .dataTables_paginate .paginate_button:hover {background-color: #64b5f6 !important; color: #64b5f6 !important; background: #64b5f6 !important; border: 1px solid #64b5f6 !important; transition: 0.25s; }
    .btn-logout{background-color:#2E8A53 ;}
    .tabs {background-color: #64b5f6 !important; font-family: "Roboto" !important; }
    .tab a {color: black !important; font-family: "Roboto" !important; } 
    .tab a.active {background-color: #f1f1f1 !important; color: #1565c0 !important; font-family: "Roboto" !important; }
    .autocomplete-content.dropdown-content {width: 200px !important;}
    </style>
    <script>
        var url = '{{URL::to('/')}}';
    </script>
</head>

<body>
    @include('layouts.sideNav')
    <div id="app">
        <nav class='blue darken-4'>
            <div class="nav-wrapper">
                <a href="#" data-activates="slide-out" class="brand-logo navbar_sidebar_logo"><i class="material-icons">menu</i></a>

                <ul class="left hide-on-med-and-down">
                    <li><a href="{{URL::to('/')}}/docu" style="margin-left: 58px; font-size:30px;">PRRC</a></li>
                </ul>
                @if(Auth::user()->role->name == 'Encoder' || Auth::user()->role->name == 'Super Admin')
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a class="waves-effect waves-light btn-small green" onclick="location.href='/docu/create'"><i class="material-icons left">add</i>New Record</a></li>
                </ul>
                @endif
                @yield('search')
            </div>
            @yield('show_nav2')
        </nav>

        <div class="content" id="main">
            @yield('content')
        </div>
    </div>
    
    <script type="text/javascript" src="{{asset('js/materializev1.0.0/materialize.min.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="{{asset('js/materialize.min.js')}}"></script>

    @stack('scripts')
    <script>
        $(document).ready(function() {
            $(".brand-logo").sideNav();
        });
    </script>
</body>

</html>