<!-- Default Layout -->

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Change the title of the top navigation bar based on which page the user is currently at -->
    <title>
        @if (request()->is('profile')) Profile
        @elseif (request()->is('mycard')) MyCard
        @elseif (request()->is('home')) Home
        @elseif (request()->is('benefits')) Benefits
        @elseif (request()->is('alumnihub')) Alumni Hub
        @else {{ config('app.name', 'Uniten Alumni') }}
        @endif
    </title>



    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Styles -->
    <style>
        body {
            background: linear-gradient(to bottom, #FF0000 , #8000FF);
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        #app {
            flex: 1;
        }
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: top 0.3s ease-in-out; /* Smooth transition effect */
        }
        .bottom-navbar {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: white;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
            overflow-x: auto; /* Enables horizontal scrolling */
            white-space: nowrap; /* Prevents items from wrapping */
            display: flex;
            justify-content: flex-start;
            padding: 10px;
            scrollbar-width: thin; /* Hide scrollbar on Firefox */
        }
        .bottom-navbar::-webkit-scrollbar {
            display: none; /* Ensure scrollbar is visible */
            height: 5px; /* Set a small scrollbar height */
        }


        .bottom-navbar .container {
            display: flex;
            justify-content: center;
            flex-wrap: nowrap; /* Prevent wrapping */
            width: max-content; /* Ensure container fits all items */
            gap: 20px;
            
        }
        .bottom-navbar a {
            display: flex;
            align-items: center;
            gap: 8px; /* Space between icon and text */
            text-decoration: none;
            color: black;
            font-weight: bold;
            padding: 10px;
        }
        .bottom-navbar i {
            font-size: 18px; /* Adjust icon size */
        }
        .bottom-navbar a.active {
        color: red; /* Change text color */
        }

        .bottom-navbar a.active i {
            color: red; /* Change icon color */
        }
        
        .extra-margin { /* for padding between content and bottom navigation menu */
            margin-bottom: 100px; /* Adjust as needed */
        }


    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}"> <!-- Change the title of the top navigation bar based on which page the user is currently at -->
                    @if (request()->is('profile')) Profile
                    @elseif (request()->is('mycard')) MyCard
                    @elseif (request()->is('home')) Home
                    @elseif (request()->is('benefits')) Benefits
                    @elseif (request()->is('alumnihub')) Alumni Hub
                    @else {{ config('app.name', 'Uniten Alumni') }}
                    @endif
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @can('isAdmin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.home') }}">Alumni Homepage</a>
                        </li>
                        @endcan
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Place content here -->
        <main class="py-4 extra-margin"> <!--mb-10 is to add padding between content and bottom navigation menu -->
            @yield('content')
        </main>
    </div>

    <!-- This script is to make when user scroll down hide the top navigation bar, when user scroll up show the top navigation bar -->
    <script>
        let lastScrollTop = 0;
        const navbar = document.querySelector(".navbar");
    
        window.addEventListener("scroll", function () {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
            if (scrollTop > lastScrollTop) {
                // Scrolling Down: Hide navbar
                navbar.style.top = "-70px"; // Adjust based on navbar height
            } else {
                // Scrolling Up: Show navbar
                navbar.style.top = "0";
            }
    
            lastScrollTop = scrollTop;
        });
    </script>
    

    
    <!-- Bottom Navigation Bar -->
    <!-- If the page is current selected e.g profile, at the bottom navigation bar the profile and its icon will turn red indicating they are currently at that page -->
    <nav class="bottom-navbar">
        <div class="container">
            <a href="{{ url('/profile') }}" class="{{ request()->is('profile') ? 'active' : '' }}">
                <i class="fas fa-user"></i> Profile
            </a>
            <a href="{{ url('/mycard') }}" class="{{ request()->is('mycard') ? 'active' : '' }}">
                <i class="fas fa-id-card"></i> MyCard
            </a>
            <a href="{{ url('/home') }}" class="{{ request()->is('home') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Home
            </a>
            <a href="{{ url('/benefits') }}" class="{{ request()->is('benefits') ? 'active' : '' }}">
                <i class="fas fa-gift"></i> Benefits
            </a>
            <a href="{{ url('/alumnihub') }}" class="{{ request()->is('alumnihub') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Alumni Hub
            </a>
        </div>
    </nav>
    
</body>
</html>
