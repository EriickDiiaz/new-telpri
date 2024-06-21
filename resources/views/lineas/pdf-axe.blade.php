@extends('layout/pdf')

@section('title','Reportes | Axe')
@section('contenido')

<!-- Titulo de la Sección -->
<div class="d-flex align-items-center">
    <h2 class="align-middle ms-2">Reporte de Lineas Axe.</h2>
    <h4 class="align-middle ms-auto">{{ date('d-m-Y') }}</h4>
</div>

<!-- Resumen de Usuarios -->
<table class="table table-striped">
    <thead>
        <tr>
            <td class="bold">Axe</td>
            <td class="bold">Cisco</td>
            <td class="bold">Ericsson</td>
            <td class="bold">Externo</td>
            <td class="bold">Total</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><span class="badge text-bg-primary rounded-pill mx-2">{{ $totalAxe }}</span></td>
            <td><span class="badge text-bg-primary rounded-pill mx-2">{{ $totalCisco }}</span></td>
            <td><span class="badge text-bg-primary rounded-pill mx-2">{{ $totalEricsson }}</span></td>
            <td><span class="badge text-bg-primary rounded-pill mx-2">{{ $totalExterno }}</span></td>
            <td><span class="badge text-bg-primary rounded-pill mx-2">{{ $totalLineas }}</span></td>
        </tr>
    </tbody>
</table>

<!-- Contenido de Sección -->
<table class="table table-striped">
    <thead>
        <tr>
            <td class="bold">Linea</td>
            <td class="bold">Titular</td>
            <td class="bold">Inventario</td>
            <td class="bold">Li3</td>
            <td class="bold">Ubi/P/Cam</td>
            <td class="bold">Plataforma</td>
            <td class="bold">Estado</td>

        </tr>
    </thead>
    <tbody>
        
        @foreach ($lineas as $linea)
        <tr>
            <td>{{ $linea->linea }}</td>
            <td>{{ $linea->titular }}</td>   
            <td>{{ $linea->inventario }}</td>   
            <td>{{ $linea->mac }}</td>
            <td>{{ $linea->campo->nombre ?? 'N/A' }} /P/ {{ $linea->par }} </td>
            <td>{{ $linea->plataforma }}</td>
            <td>{{ $linea->estado }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection