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
        :root {
            --background-light: linear-gradient(to bottom right, #008B8B, #1e4225, #004d4d);
            --background-dark: #121212;
            --text-light: white;
            --text-dark: #f1f1f1;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: var(--background-light);
            color: var(--text-light);
            min-height: 100vh;
            transition: all 0.4s ease;
        }

        body.dark-mode {
            background: var(--background-dark);
            color: var(--text-dark);
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.95) !important;
        }

        .navbar .nav-link,
        .navbar-brand {
            color: #008B8B !important;
        }

        .dark-mode .navbar {
            background-color: #1e1e1e !important;
        }

        .dark-mode .navbar .nav-link,
        .dark-mode .navbar-brand {
            color: #90cdf4 !important;
        }

        .container h1, .container p {
            color: white;
            text-shadow: 1px 1px 2px #004d4d;
        }

        .dark-mode .container h1,
        .dark-mode .container p {
            color: #ccc;
            text-shadow: none;
        }

        .auth-buttons a {
            margin: 0 10px;
        }

        .toggle-theme {
            position: absolute;
            top: 10px;
            right: 20px;
            cursor: pointer;
            font-size: 1.3rem;
            background: none;
            border: none;
            color: white;
            z-index: 1000;
        }

        .dark-mode .toggle-theme {
            color: #ccc;
        }
    </style>
</head>
<body>

    <!-- Dark Mode Toggle Button -->
    <button class="toggle-theme" onclick="toggleTheme()" title="Toggle Dark/Light">
        🌞 / 🌙
    </button>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">PM Management</a>
        </div>
    </nav>

    <!-- Centered Welcome Section -->
    <div class="container d-flex vh-100 justify-content-center align-items-center text-center">
        <div>
            <h1 class="display-4 fw-bold mb-3">{{ __('messages.welcome') }}</h1>
            <p class="lead">{{ __('messages.tagline') }}</p>

            @if (Route::has('login'))
                <div class="auth-buttons mt-4">
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-light text-dark fw-bold">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light fw-bold">{{ __('messages.login') ?? 'Login' }}</a>
                    @endauth
                </div>
            @endif

            <div class="mt-3">
                <small>Current locale: {{ app()->getLocale() }}</small>
            </div>
        </div>
    </div>

    <!-- JS: Bootstrap Bundle & Dark Mode Toggle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Load theme from localStorage on page load
        document.addEventListener('DOMContentLoaded', function () {
            if (localStorage.getItem('darkMode') === 'enabled') {
                document.body.classList.add('dark-mode');
            }
        });

        // Toggle and save theme
        function toggleTheme() {
            document.body.classList.toggle('dark-mode');
            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('darkMode', 'enabled');
            } else {
                localStorage.setItem('darkMode', 'disabled');
            }
        }
    </script>
</body>
</html>
