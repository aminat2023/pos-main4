<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(to bottom right, #008B8B, #1e4225, #004d4d);
            color: white;
            min-height: 100vh;
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.95) !important;
        }

        .navbar .nav-link,
        .navbar-brand {
            color: #008B8B !important;
        }

        .container h1, .container p {
            color: white;
            text-shadow: 1px 1px 2px #004d4d;
        }

        .auth-buttons a {
            margin: 0 10px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">PM Management</a>
        </div>
    </nav>

    <!-- Centered Welcome Section -->
    <div class="container d-flex vh-100 justify-content-center align-items-center text-center">
        <div>
            <h1 class="display-4 fw-bold mb-3">Welcome to PM Management</h1>
            <p class="lead">Streamlining Your Sales, Simplifying Your Success!</p>

            @if (Route::has('login'))
                <div class="auth-buttons mt-4">
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-light text-dark fw-bold">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light fw-bold">Login</a>
                        {{-- @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-light fw-bold">Register</a>
                        @endif --}}
                    @endauth
                </div>
            @endif
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
