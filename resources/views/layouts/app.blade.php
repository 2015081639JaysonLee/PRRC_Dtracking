<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

   
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
   

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--<link rel="stylesheet" href="">-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" 
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
       
        <link rel="stylesheet" href="{{asset('css/customStyle.css')}}">
        <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href='https://fonts.googleapis.com/css?family=Barlow' rel='stylesheet'>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
       
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
        <title>{{config('app.name')}}</title>
</head>
<body>
    <div id="app">

         <!--SIDEBAR-->
			<div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                   
                    <a class="user my-2"><i class="material-icons">person</i> &nbsp;  {{ Auth::user()->username }}</a>
                    <a class=" my-2" href="/docu"><i class="fa fa-folder-open"></i>&nbsp; All Documents</a>
                    <a class=" my-2" href="/intransit"><i class="fa fa-arrow-right"></i> &nbsp; In Transit</a>
                    <a class=" my-2"href="/archived"><i class="fa fa-archive"></i>&nbsp; Archived</a>
                    <form action="{{route('logout')}}" method="POST">
                        @csrf    
                        <button class="btn btn-link logout my-2" type="submit"><i class="fa fa-sign-out"></i>&nbsp; Logout </button>
                    </form>
                  </div>
    
                <!--SIDEBAR-->
    
                <!--NAVBAR-->
                <div id="navs">
                <nav class="navbar navbar-expand-lg" id="navs" style="background-color: #203864;">
                    <ul class="nav justify-content-end">
                        <li>
                        <button class="btn mr-sm-5 my-2 open" onclick="openNav()">&#9776;</button>
                        </li>
                        <li>
                            @yield('header')
                        </li>
                    </ul>
                     <ul class="nav justify-content-end collapse navbar-collapse">
                
                       <li>
                           <a class="btn btn-link mr-sm-3 my-2 new" onclick="location.href='/docu/create'"><i class="fa fa-plus"></i> &nbsp; New Record</a>
                       </li>
                       <li>
                            <div class="form-group">
                                    <input type="text" name="search" id="search" class="form-control mr-sm-8" placeholder="Search " />
                            </div>
                            
                       </li>
                    </ul>
                
                 </nav>
                 </div>

                 @yield('header2')

                <div class="content" id="main">
                        @yield('content')
               </div>      
                       
               
              
               
       
               <script>
                       function openNav() {
                           document.getElementById("mySidenav").style.width = "200px";
                           document.getElementById("main").style.marginLeft = "200px";
                           document.getElementById("navs").style.marginLeft = "200px";
                           document.getElementById("navs2").style.marginLeft = "200px";
                       }
                       
                       function closeNav() {
                           document.getElementById("mySidenav").style.width = "0";
                           document.getElementById("main").style.marginLeft= "0";
                           document.getElementById("navs").style.marginLeft= "0";
                           document.getElementById("navs2").style.marginLeft= "0";
                       }

                       $('#myModal').on('shown.bs.modal', function () {
                     $('#myInput').trigger('focus')
})
                       </script>
    </div>
</body>
</html>
