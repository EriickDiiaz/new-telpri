<?php

namespace App\Http\Controllers;

use App\Models\Callcenter;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class CallcenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $callcenters = Callcenter::all();

        $busqueda = $request->busqueda;
                
        $callcentersQuery = Callcenter::query()
                    ->orderBy('extension')
                    ->where('extension', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('nombres', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('usuario', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('servicio', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('acceso', 'LIKE', '%'.$busqueda.'%');

        // Paginar los resultados
        $callcenters = $callcentersQuery->paginate(20);
        
        // Obtener el total de usuarios para CIC
        $totalCIC = Callcenter::where('servicio', 'CIC')->count();
        // Obtener el total de usuarios para CSI
        $totalCSI = Callcenter::where('servicio', 'CSI')->count();
        // Obtener el total de usuarios para HCM
        $totalHCM = Callcenter::where('servicio', 'HCM')->count();
        // Obtener el total de usuarios para CeCOm
        $totalCeCom = Callcenter::where('servicio', 'CeCom')->count();
        // Obtener el total de usuarios para PRO
        $totalPRO = Callcenter::where('servicio', 'PROV')->count();
        // Obtener el total de usuarios para COR
        $totalCOR = Callcenter::where('servicio', 'COR')->count();        
        // Obtener el total de todos los usuarios
        $totalCallcenter = Callcenter::count();

        return view('callcenters.index',compact(
            'callcenters','busqueda',
            'totalCIC','totalCSI',
            'totalHCM','totalCeCom','totalPRO','totalCOR',
            'totalCallcenter'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('callcenters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $errors = [
            'extension.required' => 'El campo extensión es obligatorio.',
            'extension.unique' => 'La extensión ya está en uso.',
            'extension.max' => 'La extensión no puede tener más de 6 caracteres.',
            'nombres.max' => 'Los nombres no pueden tener más de 100 caracteres.',
            'usuario.max' => 'El usuario no puede tener más de 20 caracteres.',
            'servicio.max' => 'El servicio no puede tener más de 15 caracteres.',
            'acceso.max' => 'El acceso no puede tener más de 30 caracteres.',
            'localidad.max' => 'La localidad no puede tener más de 30 caracteres.'
        ];

        $request->validate([
            'extension' =>'required|unique:callcenters|max:6',
            'nombres' =>'max:100|nullable',
            'usuario' =>'max:20|nullable',
            'servicio' =>'max:15|nullable',
            'acceso' =>'max:30|nullable',
            'localidad' =>'max:30|nullable'
        ],$errors);

        $callcenter = new Callcenter();
        $callcenter->extension = $request->input('extension');
        $callcenter->nombres = $request->input('nombres');
        $callcenter->usuario = $request->input('usuario');
        $callcenter->contrasena = $request->input('contrasena');
        $callcenter->servicio = $request->input('servicio');
        $callcenter->acceso = $request->input('acceso');
        $callcenter->localidad = $request->input('localidad');
        $callcenter->save();

        return redirect ('callcenters')->with('mensaje','Usuario guardado con exito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Callcenter $callcenter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit ($id)
    {
        $callcenter = Callcenter::find($id);
        return view('callcenters.edit',['callcenter'=>$callcenter]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $errors = [
            'extension.required' => 'El campo extensión es obligatorio.',
            'extension.unique' => 'La extensión ya está en uso.',
            'extension.max' => 'La extensión no puede tener más de 6 caracteres.',
            'nombres.max' => 'Los nombres no pueden tener más de 100 caracteres.',
            'usuario.max' => 'El usuario no puede tener más de 20 caracteres.',
            'servicio.max' => 'El servicio no puede tener más de 15 caracteres.',
            'acceso.max' => 'El acceso no puede tener más de 30 caracteres.',
            'localidad.max' => 'La localidad no puede tener más de 30 caracteres.'
        ];
        
        $request->validate([
            'extension' =>'required|max:4|unique:callcenters,extension,'.$id,
            'nombres' =>'max:100',
            'usuario' =>'max:20|unique:callcenters,usuario,'.$id,
            'contrasena' =>'max:10',
            'servicio' =>'max:15|nullable',
            'acceso' =>'max:30|nullable',
            'localidad' =>'max:30|nullable'
        ], $errors);

        $callcenter = Callcenter::find($id);
        $callcenter->extension = $request->input('extension');
        $callcenter->nombres = $request->input('nombres');
        $callcenter->usuario = $request->input('usuario');
        $callcenter->contrasena = $request->input('contrasena');
        $callcenter->servicio = $request->input('servicio');
        $callcenter->acceso = $request->input('acceso');
        $callcenter->localidad = $request->input('localidad');
        $callcenter->save();

        return redirect ('callcenters')->with('mensaje','Usuario actualizado con exito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $callcenter = Callcenter::find($id);
        $callcenter->delete();

        return redirect('callcenters')->with('mensaje','Usuario eliminado con exito.');
    }

    public function generatePDF()
    {
        // Datos que quieras pasar a la vista
        $callcenters = Callcenter::all();
        $totalCIC = Callcenter::where('servicio', 'CIC')->count();
        $totalCSI = Callcenter::where('servicio', 'CSI')->count();
        $totalHCM = Callcenter::where('servicio', 'HCM')->count();
        $totalCeCom = Callcenter::where('servicio', 'CeCom')->count();
        $totalPRO = Callcenter::where('servicio', 'PROV')->count();
        $totalCOR = Callcenter::where('servicio', 'COR')->count();
        $totalCallcenter = Callcenter::count();

        // Renderizar la vista con los datos
        $view = view('callcenters.pdf-callcenter', compact(
            'callcenters',
            'totalCIC', 'totalCSI',
            'totalHCM', 'totalCeCom', 'totalPRO', 'totalCOR',
            'totalCallcenter'
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
        return $dompdf->stream('reporte_callcenter.pdf', ['Attachment' => false]);
    }

}
