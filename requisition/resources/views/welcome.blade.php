<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-image: url('{{ asset('images/background.jpg') }}'); 
            background-size: cover;  
            background-position: center; 
            background-attachment: fixed; 
        }

        .logo-left, .logo-right {
            position: absolute;
            top: 20px;
        }

        .logo-left {
            left: 60px; 
        }

        .logo-right {
            right: 50px; 
        }

        .logo-left img, .logo-right img {
            width: 150px;  
            height: 150px; 
        }

        .container {
            text-align: center; 
            margin-top: 100px; 
        }

        h1 {
            margin: 20px 0; 
            font-size: 70px; 
            color: white; 
        }

        .nav-buttons {
            display: flex;
            flex-direction: row; 
            align-items: center; 
            justify-content: center; 
            margin-top: 20px;
        }

        .nav-buttons a {
            margin: 0 10px; 
            color: black;
            text-decoration: none;
            font-size: 20px; 
            padding: 15px 20px;
            background-color: rgba(11, 207, 233, 0.94);
            border-radius: 5px; 
            transition: background-color 0.3s; 
        }

        .nav-buttons a:hover {
            background-color: rgb(22, 130, 231);
        }
    </style>
</head>
<body>
    <div class="logo-left">
        <img src="{{ asset('images/rub.png') }}" alt="Logo 1">
    </div>

    <div class="logo-right">
        <img src="{{ asset('images/jnec.png') }}" alt="Logo 2">
    </div>

    <main>
        <div class="container">
            <h1>Welcome to Jnec Requisition Management System</h1>
            @if (Route::has('login'))
                <div class="nav-buttons">
                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </main>
</body>
</html>