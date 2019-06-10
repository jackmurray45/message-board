<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

	 	<!-- CSRF Token --> 
	    <meta name="csrf-token" content="{{ csrf_token() }}"> 
	
        <title>{{ config('app.name', 'Laravel') }}</title>
	    <!-- Scripts --> 
	    <script src="{{ asset('js/app.js') }}" defer></script> 
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        
	 
	    <!-- Fonts --> 
	    <link rel="dns-prefetch" href="https://fonts.gstatic.com"> 
	    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css"> 

        <script src="https://kit.fontawesome.com/a810d08c71.js"></script>
	 
	    <!-- Styles --> 
	    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 
        

	    <!-- Custom CSS -->
        <style>
        /* Fixed navbar */

        /* enable absolute positioning */

        .i-label{
            position:absolute;
            top:30%;
            left:95%;
            z-index:5;
        }
        .dropdown-menu {
            max-width: 180px;
        }
        .dropdown-menu li a {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .delete-post{
            position:absolute;
            left:95%;
            top: 12px;
        }

        textarea{
            resize:none;
        }

        
        
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="/">Lara-Post</a>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-expanded="false">
                        Profiles <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu">
                        <a href="/profiles"  class = 'dropdown-item'>View Profiles</a>
                        @if(!Auth::guest())
                            <a href="/profiles/following"  class = 'dropdown-item'>Profiles Following</a>
                            <div class="dropdown-divider"></div>
                            <a href="/profiles/me"  class = 'dropdown-item'>My Profile</a>
                        @endif
                    </div>
                    
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-expanded="false">
                        Posts <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu">
                        @if(!Auth::guest())
                            <a href="/posts/following"  class = 'dropdown-item'>Following Posts</a>
                        @endif
                        <a href="/posts"  class = 'dropdown-item'>All Posts</a>
                    </div>
                    
                </li>
                
                </ul>
                <div class="dropdown">
                <ul class="navbar-nav my-2 my-lg-0">
                    @if (Auth::guest())
                        @if(Request::path() == 'login' || Request::path() == 'register')
                            
                            <li class = "nav-item">
                                <a class="btn btn-link nav-link" href="/login" >Login</a>
                            </li>
                        @else
                            <li class = "nav-item">
                                <button class="btn btn-link nav-link" data-toggle="modal" data-target="#loginModal">Login</button>
                            </li>
                        @endif
                        <li class = "nav-item">
                            <a class="btn btn-link nav-link" href="/register" >Sign Up</a>
                        </li>
                    @else
                        <li class="nav-item dropdown" style = 'margin-right:50px'>
                            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                                <a href="#" onclick = "$('#logout-form').submit()" class = 'dropdown-item'><i class="fa fa-btn fa-sign-out "></i>Logout</a>
                            </div>
                            
                        </li>
                    @endif
                    
                </ul>
                
            </div>
        </nav>

        @include('modals.login')

        @yield('content') 
        <br />
    </body>
</html>


