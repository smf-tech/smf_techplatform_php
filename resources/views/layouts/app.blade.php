<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous"> 
</head>
<body>
    <div id="app">
        <div id="godown">
        <nav class="navbar navbar-expand-md navbar-dark navbar-laravel fixed-top " id="navbar">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
         </div>  
        <div class="content " id="mainContent">
                <div class="wrapper">
                        <!-- Sidebar -->
                        <nav id="sidebar">
                              
                          
                    
                            <ul class="list-unstyled components accordion" id="accordionExample">
                                    <li><a  href="{{ url('/users') }}"><i class="fas fa-users"></i> Users</a></li>
                                    <li><a  href="{{ url('/role') }}" ><i class="fab fa-critical-role"></i>Roles</a></li> 
                                    <li><a  href="{{ url('/organisation') }}" ><i class="fas fa-sitemap"></i>Organisations</a></li> 
                                    <!-- <li><a  class="active"  href='#' data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Master Tables</a>
                                        <ul class="list-unstyled components collapse show" data-parent="#accordionExample"  id="collapseOne" >
                                                <li><a  href="{{ url('/district') }}" ><i class="fas fa-sitemap"> </i>   Districts</a></li>
                                                 <li><a  href="{{ url('/taluka') }}" ><i class="fas fa-sitemap"> </i>    Talukas</a></li>
                                                <li><a  href="{{ url('/cluster') }}" ><i class="fas fa-sitemap"> </i>    Clusters</a></li>
                                                <li><a  href="{{ url('/village') }}" ><i class="fas fa-sitemap"> </i>    Villages</a></li>
                                         </ul>
                                   </li>
                                    <li><a  href="{{ url('/state') }}" ><i class="fas fa-map-marker-alt"> </i>   State</a> </li> -->
                                    <!-- <li><a  href="{{ url('/jurisdiction') }}" ><i class="fas fa-sitemap"> </i>   Jurisdictions</a></li> -->

                            </ul>
                        </nav>
                    
                    </div>
                    <div class="container card" id="content">
                        @yield('content')
                    </div>
        </div>
    </div>
     <!-- Scripts -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ asset('js/index.js') }}"></script> 
</body>
</html>
