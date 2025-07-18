<!doctype html>
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
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap 4 & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" crossorigin="anonymous" />
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- App CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @livewireStyles
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @include('layouts.includes.navBar')

                {{-- Hide toggler on small screens --}}
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <!-- Left Side -->
                    <ul class="navbar-nav mr-auto"></ul>

                    <!-- Right Side -->
                    <ul class="navbar-nav ml-auto">
                        <!-- 🌞 / 🌙 Theme Toggle -->
                        <li class="nav-item ml-2">
                            <button onclick="toggleTheme()" class="btn btn-outline-secondary btn-sm"
                                title="Toggle Theme">
                                <span id="theme-icon">🌙</span>
                            </button>
                        </li>

                        @auth
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-dark" href="#"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item text-danger font-weight-bold" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @else
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="btn btn-outline-primary btn-sm mr-2" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt"></i> Login
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    {{-- <a class="btn btn-outline-success btn-sm" href="{{ route('register') }}">
                                        <i class="fas fa-user-plus"></i> Register
                                    </a> --}}
                                </li>
                            @endif
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Go Back to Home Link -->
        @if (Request::path() !== '/')
            <div style="background: #f0f0f0; padding: 10px 20px;">
                @if (!in_array(Request::path(), ['/', 'home']))
                    <div style="background: #f0f0f0; padding: 10px 20px;">
                        <a href="{{ url('/home') }}"
                            style="text-decoration: none; color: #007bff; font-weight: bold;">
                            ← Go Back to Home
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <!-- Main Content -->
        <main class="py-4">
            @yield('content')
        </main>

        <!-- Sidebar Modal -->
        <div class="modal left fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="staticBackdropLabel">Sidebar</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @include('layouts.includes.sideBar')
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- Custom Styles -->
    <style>
        body {
            background: linear-gradient(to right, #004d4d, #007a7a); /* Deep Teal Shades */
            color: black;
            width: 100%;
            font-family: 'Nunito', sans-serif;
            transition: all 0.3s ease;
        }

        /* DARK MODE STYLES */
        body.dark-mode {
            background: linear-gradient(to bottom right, #110101, #2f3236, #1f2a38) !important;
            color: #c0e0f0 !important;
        }

        .dark-mode .navbar {
            background-color: #12181b !important;
            color: #78d1ff;
            border-bottom: 1px solid #2c3e50;
        }

        .dark-mode .dropdown-menu {
            background-color: #1f2a38;
            color: #c0e0f0;
            border: 1px solid #34495e;
        }

        .dark-mode .btn,
        .dark-mode .form-control,
        .dark-mode .modal-content {
            background-color: #28313b;
            color: #ffffff;
            border-color: #3d4f5c;
        }

        .dark-mode a {
            color: #62d4ff;
        }

        .dark-mode .btn-outline-primary {
            border-color: #62d4ff;
            color: #62d4ff;
        }

        .dark-mode .btn-outline-primary:hover {
            background-color: #62d4ff;
            color: #121212;
        }

        /* Modal slide-in from left */
        .modal.left .modal-dialog {
            position: absolute;
            top: 0;
            left: 0;
            margin: 0;
        }

        .modal.left .modal-dialog.modal-sm {
            max-width: 300px;
        }

        .modal.left .modal-content {
            border: 0;
            background: #2c3e50;
        }

        /* Header Text */
        h4 {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 30px;
            font-weight: bolder;
            text-transform: uppercase;
            color: #b6dfff;
        }

        @media (max-width: 767.98px) {
            .navbar-nav.ml-auto .nav-item {
                text-align: center;
            }

            .navbar-nav.ml-auto .btn,
            .navbar-nav.ml-auto .dropdown-toggle {
                width: 100%;
                text-align: left;
            }
        }
    </style>

    <!-- Scripts (Bootstrap 4) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <!-- SweetAlert & Livewire -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="{{ asset('js/custom_livewire.js') }}"></script>
    @livewireScripts

    @yield('script')

    <!-- Dark Mode Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mode = localStorage.getItem('darkMode');
            if (mode === 'enabled') {
                document.body.classList.add('dark-mode');
                document.getElementById('theme-icon').textContent = '🌞';
            } else {
                document.getElementById('theme-icon').textContent = '🌙';
            }
        });

        function toggleTheme() {
            const body = document.body;
            const icon = document.getElementById('theme-icon');
            body.classList.toggle('dark-mode');
            const enabled = body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', enabled ? 'enabled' : 'disabled');
            icon.textContent = enabled ? '🌞' : '🌙';
        }
    </script>
</body>

</html>
