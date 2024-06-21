@extends('layout/template')

@section('title','Pisos | Crear')
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
    <i class="bi bi-building" style="font-size:150%;"></i>
    <h2 class="align-middle">Crear Piso.</h2>
</div>

<!--Contenido de la Sección -->
<form action="{{ url('pisos') }}" method="post">
    @csrf

    <div>
        <label for="nombre" class="col-sm-2 col-form-label">Nombre de piso:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre') }}" required>
        </div>
    </div>

    <div>
        <label for="localidad_id" class="col-sm-2 col-form-label">Localidad:</label>
        <div class="col-sm-5">
            <select name="localidad_id" id="localidad_id" class="form-select">
                <option value="{{ old('localidad_id') }}">{{ old('localidad_id') }}</option>
                @foreach($localidades as $localidad)
                <option value="{{ $localidad->id }}">{{ $localidad->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ url('pisos') }}" class="btn btn-outline-danger btn-sm">
            <i class="bi bi-backspace"></i>
            <span>Regresar</span>
        </a>
        |
        <button type="submit" class="btn btn-outline-success btn-sm">
            <i class="bi bi-building-add"></i>
            <span>Agregar</span>
        </button>
    </div>
                
</form>

@endsection