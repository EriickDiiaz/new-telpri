@extends('layout/template')

@section('title','Lineas | Historial de Linea')
@section('contenido')

<!-- Titulo de la Sección -->
<div class="d-flex">
    <i class="bi bi-clock-history" style="font-size:150%;"></i>
    <h2 class="align-middle">Historial de Línea {{ $linea->linea }}.</h2>
</div>

<!--Contenido de la Sección -->

@endsection