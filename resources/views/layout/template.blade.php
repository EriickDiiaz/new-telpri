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

    <!-- Sweet Alert 2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Estilos personalizados */
        .sidebar {
            background-color: #2B3035;
            color: #fff;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            width: 18%;
            padding-top: 3rem;
        }
        .sidebar a {
            color: #fff;
        }
        .admin-navbar {
            background-color: #0098DA;
            margin-left: 18%;
        }
        i{
            font-size:120%;
            margin:1px;
        }
        .contenido{
            margin-left: 18%;
            min-height: 570px;
        }
        .footer{
            margin-left: 18%;
        }
               
    </style>
</head>
<body>

<!-- Navbar para administración de usuario -->
<nav class="navbar navbar-expand-lg admin-navbar border-bottom" >
    <div class="container-fluid">
        <div>
            <i class="bi bi-bar-chart-steps"></i> ...
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
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
                            <a class="dropdown-item" href="{{ url('usuarios/'.Auth::user()->id.'/edit')}}">
                                <i class="bi bi-person-exclamation"></i> {{ __('Modificar Usuario') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i> {{ __('Cerrar Sesión') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<nav class="sidebar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/home') }}">
            <img src="{{ asset('imagenes/Logo_TelPriWeb_Wh.png') }}" alt="Logo TelPri" style="width: 100%;" class="py-3">
        </a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ps-0">
            <li class="border-top my-3 nav-item"></li>
            <li class="mb-1 nav-item">
                <button class="btn btn-toggle align-items-center rounded collapsed fw-medium" data-bs-target="#dashboard-collapse" aria-expanded="false">
                    <a class="nav-link" href="{{ url('/lineas') }}">
                    <i class="bi bi-telephone"></i> Líneas</a>
                </button>
            </li>
            <li class="mb-1 nav-item">
                <button class="btn btn-toggle align-items-center rounded collapsed fw-medium" data-bs-target="#dashboard-collapse" aria-expanded="false">
                    <a class="nav-link" href="{{ url('/callcenters') }}">
                    <i class="bi bi-headset"></i> CallCenters</a>
                </button>
            </li>
            <li class="border-top my-3 nav-item"></li>
            @can('Menu Localidades')
            <li class="mb-1 nav-item">
                <button class="btn btn-toggle align-items-center rounded collapsed fw-medium" data-bs-toggle="collapse" data-bs-target="#localidades-collapse" aria-expanded="false">
                    <i class="bi bi-building"></i>
                    Adm. de Localidades
                </button>
                <div class="collapse" id="localidades-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link dropdown-item px-3" href="{{ url('/localidades') }}">Localidades</a></li>
                        <li class="nav-item"><a class="nav-link dropdown-item px-3" href="{{ url('/pisos') }}">Pisos</a></li>
                        <li class="nav-item"><a class="nav-link dropdown-item px-3" href="{{ url('/campos') }}">Campos</a></li>
                    </ul>
                </div>
            </li>
            <li class="mb-1 nav-item">
                <button class="btn btn-toggle align-items-center rounded collapsed fw-medium" data-bs-target="#dashboard-collapse" aria-expanded="false">
                    <a class="nav-link" href="{{ url('/usuarios') }}">
                    <i class="bi bi-person"></i> Adm. de Usuarios</a>
                </button>
            </li>
            @endcan
            @can('Menu Sistema')
            <li class="border-top my-3 nav-item"></li>
            <li class="mb-1 nav-item">
                <button class="btn btn-toggle align-items-center rounded collapsed fw-medium" data-bs-toggle="collapse" data-bs-target="#sistema-collapse" aria-expanded="false">
                    <i class="bi bi-gear"></i>
                    Adm. de Sistema
                </button>
                <div class="collapse" id="sistema-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small navbar-nav me-auto mb-2 mb-lg-0">                        
                        <li class="nav-item"><a class="nav-link dropdown-item px-3" href="{{ url('/roles') }}">Adm. de Roles</a></li>
                        <li class="nav-item"><a class="nav-link dropdown-item px-3" href="{{ url('/permisos') }}">Adm. de Permisos</a></li>
                    </ul>
                </div>
            </li> 
            @endcan          
        </ul>
        <div class="row mt-3">
            <div class="col-md-12 text-center position-absolute bottom-0 p-3">
            <img src="{{ asset('imagenes/Logo_cantv_Wh.png') }}" alt="Logo CANTV" class="img-fluid" style="width: 50%;">
            </div>
        </div>
    </div>   
</nav>

<!-- Contenido principal -->
<main class="contenido px-2 my-3">
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
        <div class="row mt-1">
            <div class="col-md-12 text-center">
                <p>
                    © 2024 TelPri-Web. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</footer>
<!-- Scripts Bootstrap -->
<script src="{{ asset('css/bootstrap-5.3.3/js/bootstrap.bundle.min.js') }}"></script>
<!-- Scripts DataTables -->


</body>
</html>
