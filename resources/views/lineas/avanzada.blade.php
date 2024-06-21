@extends('layout/template')

@section('title','TelPri-Web | Busqueda Avanzada')
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
    <i class="bi bi-telephone" style="font-size:150%;"></i>
    <h2 class="align-middle">Busqueda Avanzada de Líneas Telefónicas.</h2>
</div>

<div class="d-flex justify-content-between">
    <!-- Botones izquierda -->
    <div class="d-flex">
        <a href="{{ url('lineas/create') }}" class="btn btn-outline-success btn-sm me-2">
            <i class="bi bi-telephone-plus"></i>
            <span>Agregar Línea</span>
        </a>
    </div>
</div>

<!-- Campos de Busqueda -->
<form class="d-flex flex-wrap" role="search" action="{{ route('lineas/avanzada') }}" method="get">
    <div class="d-flex flex-wrap w-100">
        <div class="col-sm-2 me-3">
            <label for="linea" class="col-form-label">Línea:</label>
            <input type="text" class="form-control" name="linea" id="linea" value="{{ request('linea') }}">
        </div>

        <div class="col-sm-1 me-3">
            <label for="vip" class="col-form-label">¿VIP?</label>
            <select name="vip" id="vip" class="form-select">
                <option value="">{{ request('vip') ? request('vip') : 'Seleccione' }}</option>
                <option value="No" {{ request('vip') == 'No' ? 'selected' : '' }}>No</option>
                <option value="Presidente" {{ request('vip') == 'Presidente' ? 'selected' : '' }}>Presidente</option>
                <option value="Vice Presidente" {{ request('vip') == 'Vice Presidente' ? 'selected' : '' }}>Vice Presidente</option>
                <option value="Gerente General" {{ request('vip') == 'Gerente General' ? 'selected' : '' }}>Gerente General</option>
                <option value="Asesor" {{ request('vip') == 'Asesor' ? 'selected' : '' }}>Asesor</option>
                <option value="Asistente" {{ request('vip') == 'Asistente' ? 'selected' : '' }}>Asistente</option>
            </select>
        </div>

        <div class="col-sm-2 me-3">
            <label for="inventario" class="col-form-label">Cod. Inventario:</label>
            <input type="text" class="form-control" name="inventario" id="inventario" value="{{ request('inventario') }}">
        </div>

        <div class="col-sm-2 me-3">
            <label for="serial" class="col-form-label">Serial:</label>
            <input type="text" class="form-control" name="serial" id="serial" value="{{ request('serial') }}">
        </div>

        <div class="col-sm-2 me-3">
            <label for="plataforma" class="col-form-label">Plataforma:</label>
            <select name="plataforma" id="plataforma" class="form-select">
                <option value="">{{ request('plataforma') ? request('plataforma') : 'Seleccione' }}</option>
                <option value="Axe" {{ request('plataforma') == 'Axe' ? 'selected' : '' }}>Axe</option>
                <option value="Cisco" {{ request('plataforma') == 'Cisco' ? 'selected' : '' }}>Cisco</option>
                <option value="Ericsson" {{ request('plataforma') == 'Ericsson' ? 'selected' : '' }}>Ericsson</option>
                <option value="Externo" {{ request('plataforma') == 'Externo' ? 'selected' : '' }}>Externo</option>
            </select>
        </div>

        <div class="col-sm-1 me-3">
            <label for="estado" class="col-form-label">Estado:</label>
            <select name="estado" id="estado" class="form-select">
                <option value="">{{ request('estado') ? request('estado') : 'Seleccione' }}</option>
                <option value="Disponible" {{ request('estado') == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="Asignada" {{ request('estado') == 'Asignada' ? 'selected' : '' }}>Asignada</option>
                <option value="Bloqueada" {{ request('estado') == 'Bloqueada' ? 'selected' : '' }}>Bloqueada</option>
                <option value="Por Verificar" {{ request('estado') == 'Por Verificar' ? 'selected' : '' }}>Por Verificar</option>
                <option value="Por Eliminar" {{ request('estado') == 'Por Eliminar' ? 'selected' : '' }}>Por Eliminar</option>
            </select>
        </div>
    </div>

    <div class="d-flex flex-wrap w-100">
        <div class="col-sm-2 me-3 mb-3">
            <label for="titular" class="col-form-label">Titular:</label>
            <input type="text" class="form-control" name="titular" id="titular" value="{{ request('titular') }}">
        </div>

        <div class="col-sm-2 me-3">
            <label for="localidad_id" class="col-form-label">Localidad:</label>
            <select name="localidad_id" id="localidad_id" class="form-select">
                <option value="">{{ request('localidad_id') ? request('localidad_id') : 'Seleccione' }}</option>
                @foreach($localidades as $localidad)
                    <option value="{{ $localidad->id }}" {{ request('localidad_id') == $localidad->id ? 'selected' : '' }}>{{ $localidad->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-sm-1 me-3">
            <label for="piso_id" class="col-form-label">Piso:</label>
            <select name="piso_id" id="piso_id" class="form-select">
                <option value="{{ request('piso') }}">Seleccione un Piso</option>
            </select>
        </div>

        <div class="col-sm-2 me-3">
            <label for="mac" class="col-form-label">Mac/EQ/LI3:</label>
            <input type="text" class="form-control" name="mac" id="mac" value="{{ request('mac') }}">
        </div>

        <div class="col-sm-2 me-3">
            <label for="campo_id" class="col-form-label">Ubicación:</label>
            <select name="campo_id" id="campo_id" class="form-select">
                <option value="">{{ request('campo_id') ? request('campo_id') : 'Seleccione' }}</option>
                @foreach($campos as $campo)
                    <option value="{{ $campo->id }}" {{ request('campo_id') == $campo->id ? 'selected' : '' }}>{{ $campo->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-sm-1 me-3">
            <label for="par" class="col-form-label">Campo:</label>
            <input type="text" class="form-control" name="par" id="par" value="{{ request('par') }}">
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ url('lineas') }}" class="btn btn-outline-danger">
            <i class="bi bi-backspace"></i>
            <span>Regresar</span>
        </a>
        |
        <a href="{{ route('lineas/avanzada') }}" class="btn btn-outline-secondary">
            <i class="bi bi-x-circle"></i>
            <span>Reestablecer</span>
        </a>
        |
        <button type="submit" class="btn btn-outline-success">
            <i class="bi bi-binoculars"></i>
            <span>Búsqueda Avanzada</span>
        </button>
    </div>
</form>
<!-- Tabla donde se muestran resultados -->
@if(isset($lineas))
    <div class="mt-5">
        <h3>Resultados de la búsqueda</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Línea</th>
                    <th>VIP</th>
                    <th>Cod. Inv.</th>
                    <th>Serial</th>
                    <th>Plataforma</th>
                    <th>Estado</th>
                    <th>Titular</th>
                    <th>Localidad</th>
                    <th>Piso</th>
                    <th>Mac/EQ/LI3</th>
                    <th>Campo</th>
                    <th>Par</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lineas as $linea)
                    <tr>
                        <td>
                            <a href="{{ url('lineas/'.$linea->id)}}" target="_blank">{{ $linea->linea }}</a>
                        </td>
                        <td>{{ $linea->vip }}</td>
                        <td>{{ $linea->inventario }}</td>
                        <td>{{ $linea->serial }}</td>
                        <td>{{ $linea->plataforma }}</td>
                        <td>{{ $linea->estado }}</td>
                        <td>{{ $linea->titular }}</td>
                        <td>{{ $linea->localidad->nombre ?? 'N/A' }}</td>
                        <td>{{ $linea->piso->nombre ?? 'N/A'}}</td>
                        <td>{{ $linea->mac }}</td>
                        <td>{{ $linea->campo->nombre ?? 'N/A' }}</td>
                        <td>{{ $linea->par }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="12">{{ $lineas->appends(request()->query())->links() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#localidad_id').change(function() {
        var localidadID = $(this).val();
        if(localidadID) {
            $.ajax({
                url: '{{ url("/get-pisos") }}/' + localidadID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#piso_id').empty();
                    $('#piso_id').append('<option value="">Seleccione un piso</option>');
                    $.each(data, function(key, value) {
                        $('#piso_id').append('<option value="'+ value.id +'">'+ value.nombre +'</option>');
                    });
                }
            });
        } else {
            $('#piso_id').empty();
            $('#piso_id').append('<option value="">Seleccione un piso</option>');
        }
    });
});
</script>

@endsection
