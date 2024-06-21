@extends('layout/pdf')

@section('title','Reportes | CallCenters')
@section('contenido')

<!-- Titulo de la Sección -->
<div class="d-flex align-items-center">
    <h2 class="align-middle ms-2">Reporte de Usuarios CallCenter.</h2>
    <h4 class="align-middle ms-auto">{{ date('d-m-Y') }}</h4>
</div>

<!-- Resumen de Usuarios -->
<table class="table table-striped">
    <thead>
        <tr>
            <td class="bold">CIC</td>
            <td class="bold">CSI</td>
            <td class="bold">HCM</td>
            <td class="bold">CeCOM</td>
            <td class="bold">PRO</td>
            <td class="bold">COR</td>
            <td class="bold">Total</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><span class="badge text-bg-primary rounded-pill mx-2">{{ $totalCIC }}</span></td>
            <td><span class="badge text-bg-primary rounded-pill mx-2">{{ $totalCSI }}</span></td>
            <td><span class="badge text-bg-primary rounded-pill mx-2">{{ $totalHCM }}</span></td>
            <td><span class="badge text-bg-primary rounded-pill mx-2">{{ $totalCeCom }}</span></td>
            <td><span class="badge text-bg-primary rounded-pill mx-2">{{ $totalPRO}}</span></td>
            <td><span class="badge text-bg-primary rounded-pill mx-2">{{ $totalCOR }}</span></td>
            <td><span class="badge text-bg-primary rounded-pill mx-2">{{ $totalCallcenter }}</span></td>
        </tr>
    </tbody>
</table>

<!-- Contenido de Sección -->
<table class="table table-striped">
    <thead>
        <tr>
            <td>Extensión</td>
            <td>Nombres</td>
            <td>Usuario</td>
            <td>Pass</td>
            <td>Servicio</td>
            <td>Accesso</td>
            <td>Localidad</td>
        </tr>
    </thead>
    <tbody>
        
        @foreach ($callcenters as $callcenter)
        <tr>
            <td>{{ $callcenter->extension }}</td>
            <td>{{ $callcenter->nombres }}</td>   
            <td>{{ $callcenter->usuario }}</td>   
            <td>{{ $callcenter->contrasena }}</td>                        
            <td>{{ $callcenter->servicio }}</td>   
            <td>{{ $callcenter->acceso }}</td>
            <td>{{ $callcenter->localidad }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection