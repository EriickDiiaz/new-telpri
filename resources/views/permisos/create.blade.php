@extends('layout/template')

@section('title','Permisos | Crear Permiso')
@section('contenido')

<!-- Mensajes y Notificaciones -->
@if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>¡Uy!</strong> Revisa los siguientes errores antes de continuar.
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Titulo de la Sección -->
<div class="d-flex">
    <i class="bi bi-person-add" style="font-size:150%;"> </i>
    <h2 class="align-middle">Crear Permiso.</h2>
</div>

<!--Contenido de la Sección -->
<form action="{{ url('permisos') }}" method="post">
    @csrf

    <div>
        <label for="name" class="col-sm-2 col-form-label">Nombre del Permiso:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ url('permisos') }}" class="btn btn-outline-danger btn-sm">
            <i class="bi bi-backspace"></i>
            <span>Regresar</span>
        </a>
        |
        <button type="submit" class="btn btn-outline-success btn-sm">
            <i class="bi bi-patch-plus"></i>
            <span>Agregar</span>
        </button>
    </div>               
</form>

@endsection