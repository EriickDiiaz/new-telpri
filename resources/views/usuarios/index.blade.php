@extends('layout/template')

@section('title','TelPri-Web | Usuarios')
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
    <i class="bi bi-person"  style="font-size:150%;"></i>
    <h2 class="align-middle">Administrador de Usuarios.</h2>
</div>

<!-- Botón Agregar -->
<a href="{{ url('usuarios/create') }}" class="btn btn-outline-success btn-sm me-2">
    <i class="bi bi-person-add"></i>
    <span class="align-middle">Agregar Usuario</span>
</a>

<!-- Barra de Búsqueda -->       

<!-- Resumen de Localidades -->
<div class="d-flex justify-content-between mx-2 py-2 col-8">
    <div class="align-items-center">
        <button class="btn btn-outline-primary btn-sm" disabled>
            Total:
            <span class="badge text-bg-primary rounded-pill mx-2">{{ $totalUsuarios }}</span>
        </button>
    </div>
</div>

<!-- Contenido de Sección -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nombres</th>
            <th>Usuario</th>
            <th>Rol</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if(count($usuarios)<=0)
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
        @foreach ($usuarios as $usuario)
        <tr>
            <td>{{ $usuario->name }}</td>
            <td>{{ $usuario->email }}</td>
            <td>
                @if($usuario->roles->isNotEmpty())
                    {{ $usuario->roles->first()->name }}
                @else
                    Sin rol
                @endif
            </td>
            <td>
                <a href="{{ url('usuarios/'.$usuario->id.'/edit')}}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                |
                <form action="{{ url('usuarios/'.$usuario->id)}}" id="form-eliminar-{{ $usuario->id }}" action="{{ route('usuarios.destroy', $usuario->id) }}" class="d-inline" method="post">
                    @method("DELETE")
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-person-dash"></i>
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