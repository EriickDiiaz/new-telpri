@extends('layout/template')

@section('title','Telpri-Web')
@section('contenido')

<!-- Mensajes y Notificaciones -->
@if(Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <i class="bi bi-check2-circle"></i>
        {{ Session::get('mensaje') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Contenido de la Sección -->
<div class="container my-3">
    <div class="row justify-content-center">
        <div class="justify-content-center text-center">
            <div class="">
                <h4>Bienvenido, {{ Auth::user()->name }}:</h4>
                <div class=" text-center">
                    <img src="{{ asset('imagenes/Logo_TelPriWeb_Wh.png') }}" alt="Imagen 2" class="img-fluid" style="width: 10%;">
                </div>
            </div>
        </div>
    </div>

    <h4>Resumen de líneas telefónicas.</h4>
    <table class="table table-striped">
            <thead>
                <tr>
                    <th>Plataforma</th>
                    <th>Asignadas</th>
                    <th>Disponibles</th>
                    <th>Bloqueada</th>
                    <th>Por Verificar</th>
                    <th>Por Eliminar</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>Axe</td>
                <td>{{ $axeAsig }}</td>
                <td>{{ $axeDisp }}</td>
                <td>{{ $axeBloq }}</td>
                <td>{{ $axeVeri }}</td>
                <td>{{ $axeElim }}</td>
                <td>{{ $totalAxe }}</td>
                
            </tr>
            <tr>
                <td>Cisco</td>
                <td>{{ $ciscoAsig }}</td>
                <td>{{ $ciscoDisp }}</td>
                <td>{{ $ciscoBloq }}</td>
                <td>{{ $ciscoVeri }}</td>
                <td>{{ $ciscoElim }}</td>
                <td>{{ $totalCisco }}</td>
            </tr>
            <tr>
                <td>Ericsson</td>
                <td>{{ $ericssonAsig }}</td>
                <td>{{ $ericssonDisp }}</td>
                <td>{{ $ericssonBloq }}</td>
                <td>{{ $ericssonVeri }}</td>
                <td>{{ $ericssonElim }}</td>
                <td>{{ $totalEricsson }}</td>
            </tr>
            <tr>
                <td>Externos</td>
                <td>{{ $externoAsig }}</td>
                <td>{{ $externoDisp }}</td>
                <td>{{ $externoBloq }}</td>
                <td>{{ $externoVeri }}</td>
                <td>{{ $externoElim }}</td>
                <td>{{ $totalExterno }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <td>{{ $totalAsig }}</td>
                <td>{{ $totalDisp }}</td>
                <td>{{ $totalBloq }}</td>
                <td>{{ $totalVeri }}</td>
                <td>{{ $totalElim }}</td>
                <td>{{ $totalLineas }}</td>
            </tr>
        </tfoot>
    </table>

</div>
@endsection
