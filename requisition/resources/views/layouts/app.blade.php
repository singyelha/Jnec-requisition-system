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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Vite Assets (Loads compiled app.css and app.js) --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- Custom Styles for Fixed Header Offset --}}
    <style>
        body {
            /* !!! IMPORTANT: Adjust 80px to match your actual fixed navbar height !!! */
            padding-top: 80px;
        }
        .navbar.fixed-top {
             /* Example height adjustment - keep or remove based on your needs */
            padding-top: 0.8rem;
            padding-bottom: 0.8rem;
            min-height: 80px;
        }
         .navbar-brand img {
             max-height: 64px; /* Example logo height */
             width: auto;
             margin-right: 1rem;
        }
         /* Optional: Align items better in taller navbar */
         .navbar.fixed-top .container,
         .navbar.fixed-top .navbar-collapse ul {
            align-items: center;
        }
         #navbarDropdown i.fa-user {
            font-size: 1.25rem; /* Example larger icon */
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div id="app">
        {{-- Your Existing Fixed Navbar (Example based on previous code) --}}
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/2.png') }}" alt="Logo"> {{-- Your Logo --}}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        {{-- Add Your Links Here --}}
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            {{-- Login/Register Links --}}
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                     <i class="fas fa-user me-1"></i> {{-- Icon only --}}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                     @if (Route::has('profile.show'))
                                         <a class="dropdown-item" href="{{ route('profile.show') }}">{{ __('Profile') }}</a>
                                     @endif
                                     <div class="dropdown-divider"></div>
                                     <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                                     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Main Content Area - WHERE YOUR DASHBOARD WILL BE INJECTED --}}
        <main class="py-0"> {{-- Removed py-4, padding handled by content-area now --}}
            @yield('content')
        </main>
    </div>

    {{-- Stack for page-specific scripts (Optional but good practice) --}}
    @stack('scripts')
</body>
</html>