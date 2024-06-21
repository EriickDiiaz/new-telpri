@extends('layout/template')

@section('title','TelPri-Web | CallCenters')
@section('contenido')

<!-- Mensajes y Notificaciones -->
@if(Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <i class="bi bi-check2-circle"></i>
        {{ Session::get('mensaje') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Titulo de la Sección -->
<div class="d-flex">
    <i class="bi bi-4x bi-headset" style="font-size:150%;"> </i>
    <h2 class="align-middle">Usuarios CallCenter.</h2>
</div>

<!-- Botón Agregar -->
<div class="d-flex justify-content-between">
    <div class="d-flex">   
        <a href="{{ url('callcenters/create') }}" class="btn btn-outline-success btn-sm me-2">
            <i class="bi bi-person-add"></i>
            <span class="">Agregar Usuario</span>
        </a>
<!-- Botón PDF -->
        <a href="{{ url('callcenters/pdf-callcenter') }}" class="btn btn-outline-light btn-sm " target="_blank">
            <i class="bi bi-file-earmark-pdf" style="font-size:120%;"></i>
            <span>Generar Reporte</span>
        </a>
    </div>  
<!-- Barra de Búsqueda -->       
    <form class="d-flex" role="search" action="{{route('callcenters.index')}}" method="get">
        <input class="form-control me-2" type="search" placeholder="Busqueda" aria-label="Search" name="busqueda" value="{{$busqueda}}">
        <button class="btn btn-outline-success" type="submit">
            <i class="bi bi-search align-middle"></i>
        </button>
    </form>
</div>
<!-- Resumen de Usuarios -->
<div class="d-flex justify-content-between py-2 col-7">
    <div class="align-items-center">
        <button class="btn btn-outline-light btn-sm" disabled>
            CIC:
            <span class="badge text-bg-primary rounded-pill mx-2">{{ $totalCIC }}</span>
        </button>
    </div>
    <div class="align-items-center">
        <button class="btn btn-outline-light btn-sm" disabled>
            CSI:
            <span class="badge text-bg-primary rounded-pill mx-2">{{ $totalCSI }}</span>
        </button>
    </div>
    <div class="align-items-center">
        <button class="btn btn-outline-light btn-sm" disabled>
            HCM:
            <span class="badge text-bg-primary rounded-pill mx-2">{{ $totalHCM }}</span>
        </button>
    </div>
    <div class="align-items-center">
        <button class="btn btn-outline-light btn-sm" disabled>
            CeCOM:
            <span class="badge text-bg-primary rounded-pill mx-2">{{ $totalCeCom }}</span>
        </button>
    </div>
    <div class="align-items-center">
        <button class="btn btn-outline-light btn-sm" disabled>
            PRO:
            <span class="badge text-bg-primary rounded-pill mx-2">{{ $totalPRO}}</span>
        </button>
    </div>
    <div class="align-items-center">
        <button class="btn btn-outline-light btn-sm" disabled>
            COR:
            <span class="badge text-bg-primary rounded-pill mx-2">{{ $totalCOR }}</span>
        </button>
    </div>
    <div class="align-items-center">
        <button class="btn btn-outline-primary btn-sm" disabled>
            Total:
            <span class="badge text-bg-primary rounded-pill mx-2">{{ $totalCallcenter }}</span>
        </button>
    </div>
</div>
<!-- Contenido de Sección -->
<table class="table table-striped" id="callcenter">
    <thead>
        <tr>
            <th>Extensión</th>
            <th>Nombres</th>
            <th>Usuario</th>
            <th>Pass</th>
            <th>Servicio</th>
            <th>Accesso</th>
            <th>Localidad</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if(count($callcenters)<=0)
            <tr>
                <td colspan="7">                      
                    <div class="alert alert-warning d-flex align-items-center p-2" role="alert">
                        <i class="bi bi-exclamation-diamond align-middle"></i>
                        <div class="p-2">
                            ¡Uy! No hay nada que mostrar.
                        </div>
                    </div>
                </td>
            </tr>
        @else
        @foreach ($callcenters as $callcenter)
        <tr>
            <td>{{ $callcenter->extension }}</td>
            <td>{{ $callcenter->nombres }}</td>   
            <td>{{ $callcenter->usuario }}</td>   
            <td>{{ $callcenter->contrasena }}</td>                        
            <td>{{ $callcenter->servicio }}</td>   
            <td>{{ $callcenter->acceso }}</td>
            <td>{{ $callcenter->localidad }}</td>
            <td>
                <a href="{{ url('callcenters/'.$callcenter->id.'/edit')}}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                @can('Eliminar Usuario CallCenter')
                |
                <form action="{{ url('callcenters/'.$callcenter->id)}}" id="form-eliminar-{{ $callcenter->id }}" action="{{ route('callcenters.destroy', $callcenter->id) }}" class="d-inline" method="post">
                    @method("DELETE")
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-person-x"></i>
                    </button>
                </form>
                @endcan
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="8">{{$callcenters->appends(['busqueda'=>$busqueda])}}</td>
        </tr>
    </tfoot>
</table>

<script>
    document.querySelectorAll('form[id^="form-eliminar-"]').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const formId = this.id;

            Swal.fire({
                title: '¿Estás seguro de que quieres eliminar este usuario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                background: '#333',  // Fondo oscuro
                color: '#fff',       // Texto blanco
                customClass: {
                    popup: 'swal2-dark',
                    title: 'swal2-title',
                    confirmButton: 'swal2-confirm',
                    cancelButton: 'swal2-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        });
    });
</script>

@endsection