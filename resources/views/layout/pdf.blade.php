<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        /* Estilos personalizados */
        body {
            font-family: sans-serif;
        }
        .navbar-left, .navbar-right {
            display: flex;
            align-items: center;
        }
        .navbar-left img, .navbar-right img {
            width: 20%;
            padding: 1rem 0;
        }
        main {
            width: 100%;
            padding: 1rem;
        }
        footer {
            margin-top: auto;
            padding-top: 1rem;
            padding-bottom: 1rem;
            text-align: center;
        }
        footer img {
            width: 10%;
            max-width: 100%;
            height: auto;
        }
        footer p {
            margin-top: 0.5rem;
        }
        .d-flex {
            display: flex;
        }
        .align-items-center {
            align-items: center;
        }
        .align-middle {
            vertical-align: middle;
        }
        .ms-2 {
            margin-left: 0.5rem;
        }
        .ms-auto {
            margin-left: auto;
        }
        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        .col-7 {
            width: 58.333333%;
        }
        .justify-content-between {
            justify-content: space-between;
        }
        .badge {
            display: inline-block;
            padding: 0.25em 0.4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.375rem;
        }
        .text-bg-primary {
            color: #fff;
            background-color: #0d6efd;
        }
        .rounded-pill {
            border-radius: 50rem;
        }
        .mx-2 {
            margin-right: 0.5rem;
            margin-left: 0.5rem;
        }
        .bold{
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }
        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }
        .table tbody + tbody {
            border-top: 2px solid #dee2e6;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body>
    
<!-- Navbar para administración de usuario -->
<nav class="admin-navbar">
    <div class="navbar-left">
        <img src="{{ asset('imagenes/Logo_TelPriWeb_Bl.png') }}" alt="Logo TelPri">
    </div>
</nav>

<!-- Contenido principal -->
<main>
    @yield('contenido')
</main>

<!-- Footer -->
<footer>
    <div>
        <img src="{{ asset('imagenes/Logo_TelPri_Bl.png') }}" alt="Imagen 2">
    </div>
    <div>
        <p>© 2024 TelPri-Web. Todos los derechos reservados.</p>
    </div>
</footer>

</body>
</html>
