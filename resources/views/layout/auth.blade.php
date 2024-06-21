<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    
    <!-- Enlace al CSS de Bootstrap -->
    <link href="{{ asset('css/bootstrap-5.3.3/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Iconos de Bootstrap -->
    <link href="{{ asset('css/bootstrap-5.3.3/icons/font/bootstrap-icons.css') }}" rel="stylesheet">

    <style>
        /* Estilos personalizados */
        .admin-navbar {
            background-color: #0098DA;
        }
               
    </style>
</head>
<body>

<!-- Navbar para administración de usuario -->

<nav class="navbar navbar-expand-md admin-navbar shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Lado Izquierdo de NavBar -->
            <ul class="navbar-nav me-auto">
                
            </ul>

            <!-- Lado Derecho de NavBar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> {{ __('Ingresar') }}
                            </a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="bi bi-check-square"></i> {{ __('Registrar') }}
                            </a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="bi bi-person"></i> {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i> {{ __('Logout') }}
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

<!-- Contenido principal -->
<main class="px-2" style="min-height: 580px;">
    @yield('contenido')
</main>

<!-- Footer -->
<footer class="footer mt-auto">
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12 text-center">
                <img src="{{ asset('imagenes/Logo_TelPri_Wh.png') }}" alt="Imagen 2" class="img-fluid" style="width: 10%;">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 text-center">
                <p>
                    © 2024 TelPri-Web. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset('css/bootstrap-5.3.3/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>
