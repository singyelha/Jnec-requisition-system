<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts (Vite will handle JS) -->
    @vite(['resources/js/app.js'])

    <!-- Inline CSS Styles -->
    <style>
        /* Basic Reset / Font / Background */
        body {
            /* === BACKGROUND IMAGE ADDED HERE === */
            /* Replace '/images/your-background.jpg' with the path to your image in the public folder */
            background-image: url('/images/your-background.jpg');
            background-size: cover; /* Cover the entire page */
            background-position: center center; /* Center the image */
            background-repeat: no-repeat; /* Do not repeat the image */
            /* Optional: Keep background fixed during scroll */
            /* background-attachment: fixed; */

            font-family: 'Figtree', sans-serif; /* Use the font linked in the head */
            margin: 0;
            color: #333; /* Default text color */

            /* Ensure minimum height for background */
            min-height: 100vh;
        }

        /* Login Container - Full height centering */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            /* Optional: Add a subtle overlay if background makes card hard to see */
            /* background-color: rgba(0, 0, 0, 0.1); */
        }

        /* Login Card Styling */
        .login-card {
            background-color: #fff; /* Keep card opaque for readability */
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); /* Slightly stronger shadow */
            padding: 2.5rem;
            max-width: 420px;
            width: 100%;
            text-align: center; /* Center logo */
            box-sizing: border-box;
        }

        /* Logo Styling */
        .login-logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 1.5rem;
        }

        /* Title Styling */
        .login-title {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #333;
            /* === TEXT ALIGNMENT CHANGED HERE === */
            text-align: center; /* Center the Login title */
        }

        /* Form Element Styling */
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #555;
            text-align: left; /* Keep labels left-aligned */
            font-size: 0.9rem;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 1rem;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            background-clip: padding-box;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        /* Input Grouping */
        .input-group {
             margin-bottom: 0.25rem;
        }
        .input-group.mt-3 {
            margin-top: 1rem;
        }

        /* Validation Error Styling */
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        .form-control.is-invalid:focus {
             border-color: #dc3545;
             box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }
        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875em;
            display: block;
            margin-top: 0.25rem;
            margin-bottom: 1rem;
            text-align: left;
            width: 100%;
        }

        /* Remember Me Checkbox Styling */
        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            text-align: left; /* Keep checkbox area left-aligned */
            justify-content: flex-start; /* Explicitly align items to the start */
        }
        .form-check.mt-3 {
             margin-top: 1rem;
        }
        .form-check-input {
             margin-right: 0.5rem;
             margin-top: 0;
             width: 1em;
             height: 1em;
             border: 1px solid #adb5bd;
             border-radius: 0.25em;
             flex-shrink: 0; /* Prevent checkbox from shrinking */
        }
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .form-check-input:focus {
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .form-check-label {
            margin-bottom: 0;
            color: #555;
            font-size: 0.9rem;
        }

        /* Button Styling */
        .btn-primary-custom {
            display: inline-block;
            width: 100%;
            padding: 0.8rem 1rem;
            font-size: 1.05rem;
            font-weight: 500;
            color: #fff;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            user-select: none;
            background-color: #0d6efd;
            border: 1px solid #0d6efd;
            border-radius: 8px;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .mt-4 {
            margin-top: 1.5rem !important;
        }
        .btn-primary-custom:hover {
            color: #fff;
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
        .btn-primary-custom:focus {
             color: #fff;
             background-color: #0b5ed7;
             border-color: #0a58ca;
             box-shadow: 0 0 0 0.25rem rgba(49, 132, 253, 0.5);
        }

        /* Auth Links */
        .auth-links {
            margin-top: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            font-size: 0.9rem;
            gap: 1rem;
        }
         .auth-links a {
             color: #0d6efd;
             text-decoration: none;
         }
          .auth-links a:hover {
             text-decoration: underline;
         }
    </style>

</head>
<body>
    <div class="login-container">
        <div class="login-card">

            <!-- Logo -->
            <div>
                    {{-- IMPORTANT: Replace 'images/your-logo.png' with the actual path in your public folder --}}
                    <img src="{{ asset('images/2.png') }}" alt="{{ config('app.name', 'Laravel') }} Logo" class="login-logo">
                </a>
            </div>

             <h2 class="login-title">Login</h2> {{-- This title will now be centered --}}

            <!-- Session Status -->
            {{-- <x-auth-session-status class="mb-4" :status="session('status')" /> --}}

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="input-group">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Enter your email address">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="input-group mt-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                     <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
                     @error('password')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-check mt-3">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label class="form-check-label" for="remember_me">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <!-- Login Button -->
                <div class="mt-4">
                     <button type="submit" class="btn-primary-custom">
                        {{ __('Login') }}
                    </button>
                </div>

                 <!-- Links -->
                 <div class="auth-links">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">
                            {{ __('Need an account?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</body>
</html>