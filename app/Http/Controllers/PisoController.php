<?php

namespace App\Http\Controllers;

use App\Models\Localidad;
use App\Models\Piso;
use Illuminate\Http\Request;

class PisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $localidades = Localidad::all();
        
        $busqueda = $request->busqueda;
        $pisosQuery = Piso::query()->orderBy('localidad_id');

        if ($busqueda) {
            $pisosQuery->where('localidad_id', $busqueda);
        }

        $pisos = $pisosQuery->paginate(50);

        $totalPiso = Piso::count();

        return view('pisos.index', compact('pisos', 'totalPiso', 'localidades', 'busqueda'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $localidades = Localidad::orderBy('nombre')->get();
        return view('pisos.create',compact('localidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $errors = [
            'piso.required' => 'El nombre del piso es obligatorio.',
            'localidad_id.required' => 'Debes seleccionar la Localidad a la que pertenece este Piso.',
        ];

        $request->validate([
            'nombre' =>'required',
            'localidad_id' => 'required'
        ],$errors);

        $piso = new Piso();
        $piso->nombre = $request->input('nombre');
        $piso->localidad_id = $request->input('localidad_id');
        $piso->save();

        return redirect ('pisos')->with('mensaje','Piso guardado con exito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(piso $piso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $localidades = Localidad::orderBy('nombre')->get();
        $piso = Piso::find($id);
        return view('pisos.edit',compact ('piso', 'localidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $errors = [
            'piso.required' => 'El nombre del piso es obligatorio.',
            'localidad_id.required' => 'Debes seleccionar la Localidad a la que pertenece este Piso.'
        ];

        $request->validate([
            'nombre' =>'required',
            'localidad_id' => 'required'
        ],$errors);

        $piso = Piso::find($id);
        $piso->nombre = $request->input('nombre');
        $piso->localidad_id = $request->input('localidad_id');
        $piso->save();

        return redirect ('pisos')->with('mensaje','Piso guardado con exito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $piso = Piso::find($id);
        $piso->delete();

        return redirect('pisos')->with('mensaje','Piso eliminado con exito.');
    }
    
}

