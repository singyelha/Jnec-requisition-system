<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    {{-- Optional: Add Font Awesome if using icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Vite Assets (Includes Bootstrap JS/CSS likely) --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- Custom Styles for Fixed Header Adjustments --}}
    <style>
        body {
            /* === Add padding to push content below fixed navbar === */
            /* Adjust 80px if your final navbar height is different */
            padding-top: 80px;
        }
        .navbar.fixed-top {
            /* === Make Navbar Taller === */
            padding-top: 0.8rem;    /* Adjust padding for height */
            padding-bottom: 0.8rem; /* Adjust padding for height */
            min-height: 80px;     /* Ensure minimum height (h-20 equivalent) */
        }
        /* === Adjust Logo Size within Taller Navbar === */
        .navbar-brand img {
             max-height: 64px; /* Adjust (h-16 equivalent) */
             width: auto;
             margin-right: 1rem; /* Add some space next to logo */
        }
        /* Vertically center items in the taller navbar */
        .navbar.fixed-top .container,
        .navbar.fixed-top .navbar-collapse ul {
            align-items: center;
        }
        /* Optional: Adjust dropdown toggle padding if needed */
        .navbar .nav-item .dropdown-toggle {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <div id="app">
        {{-- *** USE Bootstrap 'fixed-top' class *** --}}
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
            <div class="container">
                {{-- Logo/Brand Section --}}
                <a class="navbar-brand" href="{{ route('dashboard') }}"> {{-- Use route('dashboard') or appropriate home --}}
                    {{-- Place your logo image here --}}
                    <img src="{{ asset('images/2.png') }}" alt="JNEC Requisition Logo">
                    {{-- Or Text Brand: {{ config('app.name', 'Laravel') }} --}}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        {{-- === Add ROLE-BASED Links Using Bootstrap Structure === --}}
                        {{-- Requires Spatie/laravel-permission or similar --}}
                        @role('SA') {{-- Use the exact role name --}}
                            <li class="nav-item">
                                {{-- Check if route exists before using it --}}
                                @if (Route::has('admin.users.index'))
                                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                        {{ __('Manage Users') }}
                                    </a>
                                @endif
                            </li>
                        @endrole
                        {{-- Add other links for other roles or all users --}}
                         {{-- Example:
                         <li class="nav-item">
                             <a class="nav-link {{ request()->routeIs('some.route') ? 'active' : '' }}" href="{{ route('some.route') }}">Some Link</a>
                         </li>
                         --}}
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login') && !request()->routeIs('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            {{-- Logged-in user dropdown --}}
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{-- Optional: Add user icon --}}
                                     <i class="fas fa-user me-1"></i>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                     {{-- Profile Link (Ensure route exists) --}}
                                     @if (Route::has('profile.show'))
                                         <a class="dropdown-item" href="{{ route('profile.show') }}">
                                             {{ __('Profile') }}
                                         </a>
                                     @endif
                                     {{-- Link to relevant dashboard --}}
                                     <a class="dropdown-item" href="{{ route('dashboard') }}">
                                         My Dashboard
                                     </a>
                                     <div class="dropdown-divider"></div> {{-- Optional divider --}}
                                     <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

        {{-- Main content area - Body padding handles the offset --}}
        <main class="py-4"> {{-- Keep existing padding or adjust --}}
            @yield('content')
        </main>
    </div>

    {{-- Ensure Bootstrap JS (and Popper) are loaded, usually via @vite --}}
</body>
</html>