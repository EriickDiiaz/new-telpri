@extends('layout/template')

@section('title','Líneas | Crear')
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
    <i class="bi bi-telephone-plus" style="font-size:150%;"></i>
    <h2 class="align-middle">Crear Línea Telefónica.</h2>
</div>

<!--Contenido de la Sección -->
<form action="{{ url('lineas') }}" method="post">
    @csrf

    <div>
        <label for="linea" class="col-sm-2 col-form-label">Línea:</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="linea" id="linea" value="{{ old('linea') }}" required>
        </div>
    </div>

    <div>
        <label for="plataforma" class="col-sm-2 col-form-label">Plataforma:</label>
        <div class="col-sm-7">
            <select name="plataforma" id="plataforma" class="form-select">
                <option value="{{ old('plataforma') }}">{{ old('plataforma') }}</option>
                <option value="Axe">Axe</option>
                <option value="Cisco">Cisco</option>
                <option value="Ericsson">Ericsson</option>
                <option value="Externo">Externo</option>
            </select>
        </div>
    </div>

    <div>
        <label for="estado" class="col-sm-2 col-form-label">Estado:</label>
        <div class="col-sm-7">
        <select name="estado" id="estado" class="form-select">
                <option value="{{ old('estado') }}">{{ old('estado') }}</option>
                <option value="Disponible">Disponible</option>
                <option value="Asignada">Asignada</option>
                <option value="Bloqueada">Bloqueada</option>
                <option value="Por Verificar">Por Verificar</option>
                <option value="Por Eliminar">Por Eliminar</option>
            </select>
        </div>
    </div>

    <div>
        <label for="titular" class="col-sm-2 col-form-label">Titular:</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="titular" id="titular" value="{{ old('titular') }}">
        </div>
    </div>

    <div>
        <div class="d-flex justify-content-between col-7">
            <div class="col-sm-5">
                <label for="localidad" class="col-sm-2 col-form-label">Localidad:</label>
                <select name="localidad_id" id="localidad_id" class="form-select">
                    <option value="{{ old('localidad_id') }}">{{ old('localidad_id') }}</option>
                        @foreach($localidades as $localidad)
                        <option value="{{ $localidad->id }}">{{ $localidad->nombre }}</option>
                        @endforeach
                </select>
            </div>
            <div class="col-sm-5">
                <label for="piso_id" class="col-sm-2 col-form-label">Piso:</label>
                <select name="piso_id" id="piso_id" class="form-select">
                    <option value="">Seleccione un Piso</option>
                </select>
            </div>
        </div>
    </div>

    <div>
        <label for="inventario" class="col-sm-2 col-form-label">Cod. Inventario:</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="inventario" id="inventario" value="{{ old('inventario') }}">
        </div>
    </div>

    <div>
        <label for="serial" class="col-sm-2 col-form-label">Serial:</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="serial" id="serial" value="{{ old('serial') }}">
        </div>
    </div>

    <div>
        <label for="mac" class="col-sm-2 col-form-label">Mac/EQ/LI3:</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="mac" id="mac" value="{{ old('mac') }}">
        </div>
    </div>

    <div>
        <label for="directo" class="col-sm-2 col-form-label">Directo:</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="directo" id="directo" value="{{ old('directo') }}">
        </div>
    </div>

    <div>
        <label for="campo" class="col-sm-2 col-form-label">Ubic/Par/Campo:</label>
        <div class="d-flex justify-content-between col-7">
            <div class="col-sm-6">
                <select name="campo_id" id="campo_id" class="form-select">
                    <option value="{{ old('campo_id') }}">{{ old('campo_id') }}</option>
                        @foreach($campos as $campo)
                        <option value="{{ $campo->id }}">{{ $campo->nombre }}</option>
                        @endforeach
                </select>
            </div>
            <div class="align-items-center">
                /P/
            </div>
            <div class="align-items-center">
                <input type="text" class="form-control" name="par" id="par" value="{{ old('par') }}">
            </div>
        </div>
    </div>

    @php
        $accesos = ['Interno', 'Local', 'Nacional', '0416', 'Otras Operadoras', 'Internacional'];
    @endphp

    <div>
        <label for="acceso" class="col-sm-2 col-form-label">Accesos:</label>
            <div class="d-flex justify-content-between col-7">
            @foreach ($accesos as $acceso)  
                    <input class="form-check-input" type="checkbox" name="acceso[]" value="{{ $acceso }}" id="acceso_{{ $acceso }}"
                    @if (in_array($acceso, old('acceso', $linea->acceso ?? []))) checked @endif>
                    <label class="form-check-label me-2" for="acceso_{{ $acceso }}">
                        {{ $acceso }}
                    </label>
            @endforeach
            </div>
    </div>

    <div>
        <label for="vip" class="col-sm-2 col-form-label">¿VIP?</label>
        <div class="col-sm-7">
            <select name="vip" id="vip" class="form-select">
                <option value="{{ old('vip') }}">{{ old('vip') }}</option>
                <option value="">No</option>
                <option value="Presidente">Presidente</option>
                <option value="Vice Presidente">Vice Presidente</option>
                <option value="Gerente General">Gerente General</option>
                <option value="Asesor">Asesor</option>
                <option value="Asistente">Asistente</option>
            </select>
        </div>
    </div>

    <div>
        <label for="observacion" class="col-sm-2 col-form-label">Observaciones:</label>
        <div class="col-sm-7">
            <textarea class="form-control" name="observacion" id="observacion" cols="10" rows="10"></textarea>
        </div>
    </div>

    <div>
        <label for="modificado" class="col-sm-2 col-form-label">Creado por:</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="modificado" id="modificado" value="{{ Auth::user()->name }}" readonly>
            </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ url('lineas') }}" class="btn btn-outline-danger btn-sm">
            <i class="bi bi-backspace"></i>
            <span>Regresar</span>
        </a>
        |
        <button type="submit" class="btn btn-outline-success btn-sm">
            <i class="bi bi-telephone-plus"></i>
            <span>Agregar</span>
        </button>
    </div>               
</form>

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