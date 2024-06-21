@extends('layout/template')

@section('title','Lineas | Detalles de Linea')
@section('contenido')

<!-- Titulo de la Sección -->
<div class="d-flex">
    <i class="bi bi-telephone" style="font-size:150%;"></i>
    <h2 class="align-middle">Detalles de Línea {{ $linea->linea }}.
        @if(!empty($linea->vip))
            <i class="bi bi-star text-warning"></i>
        @endif
    </h2>
</div>

<!--Contenido de la Sección -->
<div>
    <label for="linea" class="col-sm-2 col-form-label fw-bold">Línea:</label>
    <div class="col-sm-7 px-4">
        <p>{{ $linea->linea }}</p>
    </div>
</div>

@if(!empty($linea->plataforma))
<div>
    <label for="plataforma" class="col-sm-2 col-form-label fw-bold">Plataforma:</label>
    <div class="col-sm-7 px-4">
        <p>{{ $linea->plataforma }}</p>
    </div>
</div>
@endif

@if(!empty($linea->estado))
<div>
    <label for="estado" class="col-sm-2 col-form-label fw-bold">Estado:</label>
    <div class="col-sm-7 px-4">
        <p>{{ $linea->estado }}</p>
    </div>
</div>
@endif

@if(!empty($linea->titular))
<div>
    <label for="titular" class="col-sm-2 col-form-label fw-bold">Titular:</label>
    <div class="col-sm-7 px-4">
        <p>{{ $linea->titular }}</p>
    </div>
</div>
@endif

@if(!empty($linea->localidad_id) || !empty($linea->piso_id))
<div>
    <label for="localidad_id" class="col-sm-2 col-form-label fw-bold">Localidad:</label>
    <div class="col-sm-7 px-4">
        <p>
            {{ $linea->localidad->nombre ?? 'N/A'}}
            @if(!empty($linea->localidad_id) && !empty($linea->piso_id)), @endif
            {{ $linea->piso->nombre ?? 'N/A'}}
        </p>
    </div>
</div>
@endif

@if(!empty($linea->inventario))
    <div>
        <label for="inventario" class="col-sm-2 col-form-label fw-bold">Cod. Inventario:</label>
        <div class="col-sm-7 px-4">
            <p>{{ $linea->inventario }}</p>
        </div>
    </div>
@endif

@if(!empty($linea->serial))
<div>
    <label for="serial" class="col-sm-2 col-form-label fw-bold">Serial:</label>
    <div class="col-sm-7 px-4">
        <p>{{ $linea->serial }}</p>
    </div>
</div>
@endif

@if(!empty($linea->mac))
<div>
    <label for="mac" class="col-sm-2 col-form-label fw-bold">Mac/EQ/LI3:</label>
    <div class="col-sm-7 px-4">
        <p>{{ $linea->mac }}</p>
    </div>
</div>
@endif

@if(!empty($linea->directo))
<div>
    <label for="directo" class="col-sm-2 col-form-label fw-bold">Directo:</label>
    <div class="col-sm-7 px-4">
        <p>{{ $linea->directo }}</p>
    </div>
</div>
@endif

@if(!empty($linea->campo) || !empty($linea->par))
<div>
    <label for="campo" class="col-sm-2 col-form-label fw-bold">Ubic/Par/Campo:</label>
    <div class="col-sm-7 px-4">
        <p>
            {{ $linea->campo->nombre ?? 'N/A' }}
            @if(!empty($linea->campo) && !empty($linea->par)) /P/ @endif
            {{ $linea->par ?? 'N/A' }}
        </p>
    </div>
</div>
@endif

@if(!empty($linea->acceso))
<div>
    <label for="acceso" class="col-sm-2 col-form-label fw-bold">Acceso:</label>
    <div class="col-sm-7 px-4">
        <ul>
            @foreach ($linea->acceso as $acceso)
                <li>{{ $acceso }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

@if(!empty($linea->vip))
<div>
    <label for="vip" class="col-sm-2 col-form-label fw-bold">Vip:</label>
    <div class="col-sm-7 px-4">
        <p>{{ $linea->vip }}</p>
    </div>
</div>
@endif

@if(!empty($linea->observacion))
<div>
    <label for="observacion" class="col-sm-2 col-form-label fw-bold">Observaciones:</label>
    <div class="col-sm-7 px-4">
        <p>{{ $linea->observacion }}</p>
    </div>
</div>
@endif

<div>
    <label for="modificado" class="col-sm-2 col-form-label fw-bold">Ultima modificación:</label>
    <div class="col-sm-7 px-4">
        <p>{{ $linea->modificado }} {{ $linea->updated_at }}</p>
    </div>
</div>
<a href="{{ url('lineas') }}" class="btn btn-outline-danger btn-sm">
    <i class="bi bi-backspace"></i>
    <span>Regresar</span>
</a>
@can('Editar Lineas')
|
<a href="{{ url('lineas/'.$linea->id.'/edit')}}" class="btn btn-outline-primary btn-sm">
    <i class="bi bi-pencil-square"></i>
    <span>Modificar</span>
</a>
@endcan
|
<a href="#" class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#historialModal">
    <i class="bi bi-clock-history"></i>
    <span>Historial</span>
</a>
@can('Eliminar Lineas')
|
<form action="{{ url('lineas/'.$linea->id)}}" id="form-eliminar-{{ $linea->id }}" action="{{ route('lineas.destroy', $linea->id) }}" class="d-inline" method="post" style="display: none;">
    @method("DELETE")
    @csrf
    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="confirmarEliminacion('{{ $linea->id}}')">
        <i class="bi bi-telephone-x"></i>
    </button>
</form>
@endcan

<!-- Modal -->
<div class="modal fade" id="historialModal" tabindex="-1" aria-labelledby="historialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historialModalLabel">Historial de Modificaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    @foreach($linea->historial as $modificacion)
                    <tr>
                        <td>
                            <div><strong>Modificado por: </strong>{{ $modificacion->usuario->name }}</div>
                            <div>{{ $modificacion->formatted_date }}</div>
                        </td>
                        <td>
                            <div><strong>Campo modificado: </strong>{{ $columnNames[$modificacion->campo] ?? $modificacion->campo }}</div>
                            <div>
                                @if($modificacion->campo == 'localidad_id')
                                    <strong>Valor anterior: </strong>{{ \App\Models\Localidad::find($modificacion->valor_anterior)->nombre ?? $modificacion->valor_anterior }}
                                @elseif($modificacion->campo == 'piso_id')
                                    <strong>Valor anterior: </strong>{{ \App\Models\Piso::find($modificacion->valor_anterior)->nombre ?? $modificacion->valor_anterior }}
                                @elseif($modificacion->campo == 'campo_id')
                                    <strong>Valor anterior: </strong>{{ \App\Models\Campo::find($modificacion->valor_anterior)->nombre ?? $modificacion->valor_anterior }}
                                @elseif($modificacion->campo == 'acceso')
                                    @php
                                        $valorAnteriorAcceso = json_decode($modificacion->valor_anterior, true);
                                    @endphp
                                    <strong>Valor anterior: </strong>{{ is_array($valorAnteriorAcceso) ? implode(', ', $valorAnteriorAcceso) : $modificacion->valor_anterior }}
                                @else
                                    <strong>Valor anterior: </strong>{{ $modificacion->valor_anterior }}
                                @endif
                            </div>
                            <div>
                                @if($modificacion->campo == 'localidad_id')
                                    <strong>Valor actual: </strong>{{ \App\Models\Localidad::find($modificacion->valor_nuevo)->nombre ?? $modificacion->valor_nuevo }}
                                @elseif($modificacion->campo == 'piso_id')
                                    <strong>Valor actual: </strong>{{ \App\Models\Piso::find($modificacion->valor_nuevo)->nombre ?? $modificacion->valor_nuevo }}
                                @elseif($modificacion->campo == 'campo_id')
                                    <strong>Valor actual: </strong>{{ \App\Models\Campo::find($modificacion->valor_nuevo)->nombre ?? $modificacion->valor_nuevo }}
                                @elseif($modificacion->campo == 'acceso')
                                    @php
                                        $valorNuevoAcceso = json_decode($modificacion->valor_nuevo, true);
                                    @endphp
                                    <strong>Valor actual: </strong>{{ is_array($valorNuevoAcceso) ? implode(', ', $valorNuevoAcceso) : $modificacion->valor_nuevo }}
                                @else
                                    <strong>Valor actual: </strong>{{ $modificacion->valor_nuevo }}
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

@endsection