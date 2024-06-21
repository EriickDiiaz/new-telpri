<?php

namespace App\Http\Controllers;

use App\Models\Linea;
use App\Models\Localidad;
use App\Models\Campo;
use App\Models\Historial;
use App\Models\Piso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;


class LineaController extends Controller
{
    // Función privada para obtener el total de líneas para cada plataforma
    private function getTotalLineas()
    {
        $totalAxe = Linea::where('plataforma', 'Axe')->count();
        $totalCisco = Linea::where('plataforma', 'Cisco')->count();
        $totalEricsson = Linea::where('plataforma', 'Ericsson')->count();
        $totalExterno = Linea::where('plataforma', 'Externo')->count();
        $totalLineas = Linea::count();

        return [$totalAxe, $totalCisco, $totalEricsson, $totalExterno, $totalLineas];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $lineas = Linea::all();

        $busqueda = $request->busqueda;
                
        $lineasQuery = Linea::query()
                    ->orderBy('linea')
                    ->where('linea', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('plataforma', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('titular', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('inventario', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('estado', 'LIKE', '%'.$busqueda.'%');

        // Paginar los resultados
        $lineas = $lineasQuery->paginate(20);

        // Obtener el total de líneas para cada plataforma
        list($totalAxe, $totalCisco, $totalEricsson, $totalExterno, $totalLineas) = $this->getTotalLineas();

        return view('lineas.index',compact(
            'lineas','busqueda',
            'totalAxe','totalCisco','totalEricsson','totalExterno','totalLineas'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $localidades = Localidad::orderBy('nombre')->get();
        $campos = Campo::orderBy('nombre')->get();
        return view('lineas.create',compact('localidades','campos'));
    }

    public function getPisosByLocalidad($localidad_id)
    {
        $pisos = Piso::where('localidad_id', $localidad_id)->orderBy('id')->get();
        return response()->json($pisos);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $errors = [
            'linea.required' => 'Debes colocar la línea, es obligatorio.',
            'linea.max' => 'La extensión no puede tener más de 10 caracteres.',
            'inventario.max' => 'El Inventario no puede tener más de 50 caracteres.',
            'serial.max' => 'El Serial no puede tener más de 50 caracteres.',
            'plataforma.max' => 'La Plataforma no puede tener más de 20 caracteres.',
            'estado.required' => 'Debes colocar el Estado de la línea, es obligatorio.',
            'estado.max' => 'La extensión no puede tener más de 20 caracteres.',
            'titular.max' => 'El nombre del Titular no puede tener más de 100 caracteres.',
            'localidad_id.max' => 'La Localidad no puede tener más de 20 caracteres.',
            'piso_id.max' => 'El Piso no puede tener más de 15 caracteres.',
            'mac.max' => 'La Mac/EQ/LI3 no puede tener más de 50 caracteres.',
            'campo_id.max' => 'El Campo no puede tener más de 50 caracteres.',
            'par.max' => 'El Parno puede tener más de 6 caracteres.',
            'directo.max' => 'El Directo no puede tener más de 50 caracteres.',
            'observacion.max' => 'Las observaciones no puede tener más de 255 caracteres.'
        ];

        $request->validate([
            'linea' =>'required|max:10',
            'vip' =>'max:20|nullable',
            'inventario' =>'max:50|nullable',
            'serial' =>'max:50|nullable',
            'plataforma' =>'max:20|nullable',
            'estado' =>'required|max:20',
            'titular' =>'max:100|nullable',
            'acceso' => 'array',
            'acceso.*' => 'string|in:Interno,Local,Nacional,0416,Otras Operadoras,Internacional',
            'localidad_id' => 'max:20|nullable',
            'piso_id' => 'max:15|nullable',
            'mac' => 'max:50|nullable',
            'campo_id' => 'max:50|nullable',
            'par' => 'max:6|nullable',
            'directo' => 'max:50|nullable',
            'observacion' => 'max:255|nullable',
            'modificado' => 'max:50|nullable',
        ],$errors);

        $linea = new Linea();
        $linea->linea = $request->input('linea');
        $linea->vip = $request->input('vip');
        $linea->inventario = $request->input('inventario');
        $linea->serial = Str::upper($request->input('serial'));
        $linea->plataforma = $request->input('plataforma');
        $linea->estado = $request->input('estado');
        $linea->titular = Str::title($request->input('titular'));
        $linea->acceso = $request->acceso;
        $linea->localidad_id = $request->input('localidad_id');
        $linea->piso_id = $request->input('piso_id');
        $linea->mac = Str::upper($request->input('mac'));
        $linea->campo_id = $request->input('campo_id');
        $linea->par = $request->input('par');
        $linea->directo = $request->input('directo');
        $linea->observacion = $request->input('observacion');
        $linea->modificado = $request->input('modificado');
        
        $linea->save();

        return redirect ('lineas')->with('mensaje','Línea agregada con exito.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $linea = Linea::with(['historial' => function($query) {
            $query->orderBy('created_at', 'desc');
        }, 'localidad', 'piso', 'campo'])->find($id);

        // Formatear las fechas del historial
        foreach ($linea->historial as $modificacion) {
            $modificacion->formatted_date = Carbon::parse($modificacion->created_at)->format('d/m/Y h:i:s A');
        }

        // Paso las columnas con nombres más amigables
        $columnNames = [
            'linea' => 'Línea',
            'vip' => 'VIP',
            'inventario' => 'Inventario',
            'serial' => 'Serial',
            'plataforma' => 'Plataforma',
            'estado' => 'Estado',
            'titular' => 'Titular',
            'acceso' => 'Acceso',
            'localidad_id' => 'Localidad',
            'piso_id' => 'Piso',
            'mac' => 'Mac/EQ/LI3',
            'campo_id' => 'Campo',
            'par' => 'Par',
            'directo' => 'Directo',
            'observacion' => 'Observación'
        ];

        return view('lineas.show', compact('linea', 'columnNames'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $localidades = Localidad::orderBy('nombre')->get();
        $campos = Campo::orderBy('nombre')->get();
        $linea = Linea::find($id);
        $pisos = Piso::where('localidad_id', $linea->localidad_id)->orderBy('nombre')->get();

        return view('lineas.edit', compact('linea', 'localidades', 'campos', 'pisos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $errors = [
            'linea.required' => 'Debes colocar la línea, es obligatorio.',
            'linea.max' => 'La extensión no puede tener más de 10 caracteres.',
            'inventario.max' => 'El Inventario no puede tener más de 50 caracteres.',
            'serial.max' => 'El Serial no puede tener más de 50 caracteres.',
            'plataforma.max' => 'La Plataforma no puede tener más de 20 caracteres.',
            'estado.required' => 'Debes colocar el Estado de la línea, es obligatorio.',
            'estado.max' => 'La extensión no puede tener más de 20 caracteres.',
            'titular.max' => 'El nombre del Titular no puede tener más de 100 caracteres.',
            'localidad_id.max' => 'La Localidad no puede tener más de 20 caracteres.',
            'piso_id.max' => 'El Piso no puede tener más de 15 caracteres.',
            'mac.max' => 'La Mac/EQ/LI3 no puede tener más de 50 caracteres.',
            'campo_id.max' => 'El Campo no puede tener más de 50 caracteres.',
            'par.max' => 'El Par no puede tener más de 6 caracteres.',
            'directo.max' => 'El Directo no puede tener más de 50 caracteres.',
            'observacion.max' => 'Las observaciones no puede tener más de 255 caracteres.'
        ];

        $request->validate([
            'linea' =>'required|max:10',
            'vip' =>'max:20|nullable',
            'inventario' =>'max:50|nullable',
            'serial' =>'max:50|nullable',
            'plataforma' =>'max:20|nullable',
            'estado' =>'required|max:20',
            'titular' =>'max:100|nullable',
            'acceso' => 'array',
            'acceso.*' => 'string|in:Interno,Local,Nacional,0416,Otras Operadoras,Internacional',
            'localidad_id' => 'max:20|nullable',
            'piso_id' => 'max:15|nullable',
            'mac' => 'max:50|nullable',
            'campo_id' => 'max:50|nullable',
            'par' => 'max:6|nullable',
            'directo' => 'max:50|nullable',
            'observacion' => 'max:255|nullable',
            'modificado' => 'max:50|nullable',
        ], $errors);

        $linea = Linea::find($id);
        $oldValues = $linea->getOriginal();

        $linea->linea = $request->input('linea');
        $linea->vip = $request->input('vip');
        $linea->inventario = $request->input('inventario');
        $linea->serial = Str::upper($request->input('serial'));
        $linea->plataforma = $request->input('plataforma');
        $linea->estado = $request->input('estado');
        $linea->titular = Str::title($request->input('titular'));
        $linea->acceso = $request->input('acceso');
        $linea->localidad_id = $request->input('localidad_id');
        $linea->piso_id = $request->input('piso_id');
        $linea->mac = Str::upper($request->input('mac'));
        $linea->campo_id = $request->input('campo_id');
        $linea->par = $request->input('par');
        $linea->directo = $request->input('directo');
        $linea->observacion = $request->input('observacion');
        $linea->modificado = $request->input('modificado');
        
        $linea->save();

        // Guardar en el historial
        $user = Auth::user();

        $modificaciones = [
            'linea' => $request->input('linea'),
            'vip' => $request->input('vip'),
            'inventario' => $request->input('inventario'),
            'serial' => Str::upper($request->input('serial')),
            'plataforma' => $request->input('plataforma'),
            'estado' => $request->input('estado'),
            'titular' => Str::title($request->input('titular')),
            'acceso' => json_encode($request->input('acceso')), // Convertir a JSON
            'localidad_id' => $request->input('localidad_id'),
            'piso_id' => $request->input('piso_id'),
            'mac' => Str::upper($request->input('mac')),
            'campo_id' => $request->input('campo_id'),
            'par' => $request->input('par'),
            'directo' => $request->input('directo'),
            'observacion' => $request->input('observacion'),
            'modificado' => $request->input('modificado'),
        ];

        foreach ($modificaciones as $campo => $valor_nuevo) {
            $valor_anterior = $oldValues[$campo] ?? null;
            if ($campo === 'acceso') {
                $valor_anterior = json_encode($oldValues['acceso']);
            }

            if ($valor_nuevo != $valor_anterior) {
                Historial::create([
                    'linea_id' => $linea->id,
                    'usuario_id' => $user->id,
                    'campo' => $campo,
                    'valor_anterior' => $valor_anterior,
                    'valor_nuevo' => $valor_nuevo,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect('lineas')->with('mensaje', 'Línea actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $linea = Linea::find($id);
        $linea->delete();

        return redirect('lineas')->with('mensaje','Línea Telefónica eliminada con exito.');
    }

    public function axe(Request $request)
    {
        $busqueda = $request->busqueda;

        $lineas = Linea::where('plataforma', 'Axe')
            ->where(function ($query) use ($busqueda) {
                $query->where('linea', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('plataforma', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('titular', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('inventario', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('estado', 'LIKE', '%'.$busqueda.'%');
            })
            ->orderBy('linea')
            ->paginate(20);

        // Obtener el total de líneas para cada plataforma
        list($totalAxe, $totalCisco, $totalEricsson, $totalExterno, $totalLineas) = $this->getTotalLineas();

        return view('lineas.axe', compact(
            'lineas', 'busqueda',
            'totalAxe', 'totalCisco', 'totalEricsson', 'totalExterno', 'totalLineas'
        ));
    }

    public function cisco(Request $request)
    {
        $busqueda = $request->busqueda;

        $lineas = Linea::where('plataforma', 'Cisco')
            ->where(function ($query) use ($busqueda) {
                $query->where('linea', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('plataforma', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('titular', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('inventario', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('estado', 'LIKE', '%'.$busqueda.'%');
            })
            ->orderBy('linea')
            ->paginate(20);

        // Obtener el total de líneas para cada plataforma
        list($totalAxe, $totalCisco, $totalEricsson, $totalExterno, $totalLineas) = $this->getTotalLineas();

        return view('lineas.cisco', compact(
            'lineas', 'busqueda',
            'totalAxe', 'totalCisco', 'totalEricsson', 'totalExterno', 'totalLineas'
        ));
    }

    public function ericsson(Request $request)
    {
        $busqueda = $request->busqueda;

        $lineas = Linea::where('plataforma', 'Ericsson')
            ->where(function ($query) use ($busqueda) {
                $query->where('linea', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('plataforma', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('titular', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('inventario', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('estado', 'LIKE', '%'.$busqueda.'%');
            })
            ->orderBy('linea')
            ->paginate(20);

        // Obtener el total de líneas para cada plataforma
        list($totalAxe, $totalCisco, $totalEricsson, $totalExterno, $totalLineas) = $this->getTotalLineas();

        return view('lineas.ericsson', compact(
            'lineas', 'busqueda',
            'totalAxe', 'totalCisco', 'totalEricsson', 'totalExterno', 'totalLineas'
        ));
    }

    public function externo(Request $request)
    {
        $busqueda = $request->busqueda;

        $lineas = Linea::where('plataforma', 'Externo')
            ->where(function ($query) use ($busqueda) {
                $query->where('linea', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('plataforma', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('titular', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('inventario', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('estado', 'LIKE', '%'.$busqueda.'%');
            })
            ->orderBy('linea')
            ->paginate(20);

        // Obtener el total de líneas para cada plataforma
        list($totalAxe, $totalCisco, $totalEricsson, $totalExterno, $totalLineas) = $this->getTotalLineas();

        return view('lineas.externo', compact(
            'lineas', 'busqueda',
            'totalAxe', 'totalCisco', 'totalEricsson', 'totalExterno', 'totalLineas'
        ));
    }

    public function avanzada(Request $request)
    {
        $query = Linea::query();

        if ($request->filled('linea')) {
            $query->where('linea', 'like', '%' . $request->linea . '%');
        }
        if ($request->filled('vip')) {
            $query->where('vip', $request->vip);
        }
        if ($request->filled('inventario')) {
            $query->where('inventario', 'like', '%' . $request->inventario . '%');
        }
        if ($request->filled('serial')) {
            $query->where('serial', 'like', '%' . $request->serial . '%');
        }
        if ($request->filled('plataforma')) {
            $query->where('plataforma', $request->plataforma);
        }
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        if ($request->filled('titular')) {
            $query->where('titular', 'like', '%' . $request->titular . '%');
        }
        if ($request->filled('localidad_id')) {
            $query->where('localidad_id', $request->localidad_id);
        }
        if ($request->filled('piso_id')) {
            $query->where('piso_id', 'like', '%' . $request->piso_id . '%');
        }
        if ($request->filled('mac')) {
            $query->where('mac', 'like', '%' . $request->mac . '%');
        }
        if ($request->filled('campo_id')) {
            $query->where('campo_id', $request->campo_id);
        }
        if ($request->filled('par')) {
            $query->where('par', 'like', '%' . $request->par . '%');
        }

        // Paginar los resultados en grupos de 50
        $lineas = $query->paginate(50);

        $localidades = Localidad::orderBy('nombre')->get();
        $campos = Campo::orderBy('nombre')->get();

        return view('lineas.avanzada', compact('lineas', 'localidades', 'campos'));
    }

    public function generatePDF($plataforma)
    {
        // Datos que quieras pasar a la vista
        $lineas = Linea::where('plataforma', $plataforma)->get();

        // Obtener el total de líneas para cada plataforma
        list($totalAxe, $totalCisco, $totalEricsson, $totalExterno, $totalLineas) = $this->getTotalLineas();

        // Renderizar la vista con los datos
        $view = view('lineas.pdf-' . strtolower($plataforma), compact(
            'lineas',
            'totalAxe', 'totalCisco', 'totalEricsson', 'totalExterno', 'totalLineas'
        ))->render();

        // Inicializar Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Cargar el HTML en Dompdf
        $dompdf->loadHtml($view);

        // (Opcional) Configurar el tamaño y la orientación del papel
        $dompdf->setPaper('A4', 'landscape');

        // Renderizar el PDF
        $dompdf->render();

        // Descargar el PDF
        return $dompdf->stream('reporte_' . strtolower($plataforma) . '.pdf', ['Attachment' => false]);
    }
    
    public function generatePDFAxe()
    {
        return $this->generatePDF('Axe');
    }

    public function generatePDFCisco()
    {
        return $this->generatePDF('Cisco');
    }

    public function generatePDFEricsson()
    {
        return $this->generatePDF('Ericsson');
    }

    public function generatePDFExterno()
    {
        return $this->generatePDF('Externo');
    }

    public function historial($id)
    {
        $linea = Linea::with(['localidad', 'piso.localidad'])->findOrFail($id);
        return view('lineas/historial', compact('linea'));
    }
}
