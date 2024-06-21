@extends('layout/template')

@section('title','TelPri-Web | Adm. de Permisos')
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
    <i class="bi bi-gear" style="font-size:150%;"></i>
    <h2 class="align-middle">Administración de Permisos.</h2>
</div>

<!-- Botón Agregar -->
<div class="d-flex justify-content-between">
    <div class="d-flex">    
        <a href="{{ url('permisos/create') }}" class="btn btn-outline-success btn-sm me-2">
            <i class="bi bi-patch-plus"></i>
            <span class="">Agregar Permiso</span>
        </a>        
    </div>     
</div>
<!-- Contenido de Sección -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre del Permiso</th>            
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if(count($permisos)<=0)
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
        @foreach ($permisos as $permiso)
        <tr>
            <td>{{ $permiso->id }}</td>
            <td>{{ $permiso->name }}</td>
            <td>
                <a href="{{ url('permisos/'.$permiso->id.'/edit')}}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-patch-exclamation"></i>
                </a>
                |
                <form action="{{ url('permisos/'.$permiso->id)}}" id="form-eliminar-{{ $permiso->id }}" action="{{ route('permisos.destroy', $permiso->id) }}" class="d-inline" method="post">
                    @method("DELETE")
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-patch-minus"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>

<script>
    document.querySelectorAll('form[id^="form-eliminar-"]').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const formId = this.id;

            Swal.fire({
                title: '¿Estás seguro de que quieres eliminar este permiso?',
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