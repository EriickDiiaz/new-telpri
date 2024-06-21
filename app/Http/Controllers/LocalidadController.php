<?php

namespace App\Http\Controllers;

use App\Models\localidad;
use Illuminate\Http\Request;

class LocalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $localidades = Localidad::orderBy('nombre')->get();
        $totalLocalidad = Localidad::count();
        return view('localidades.index', compact('localidades','totalLocalidad'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('localidades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $errors = [
            'nombre.required' => 'El campo localidad es obligatorio.',
        ];

        $request->validate([
            'nombre' =>'required',
        ],$errors);

        $localidad = new Localidad();
        $localidad->nombre = $request->input('nombre');
        $localidad->save();

        return redirect ('localidades')->with('mensaje','Localidad guardada con exito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(localidad $localidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $localidad = Localidad::find($id);
        return view('localidades.edit',['localidad'=>$localidad]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $errors = [
            'nombre.required' => 'El campo nombre es obligatorio.',
        ];
        
        $request->validate([
            'nombre' =>'required',
        ], $errors);

        $localidad = Localidad::find($id);
        $localidad->nombre = $request->input('nombre');        
        $localidad->save();

        return redirect ('localidades')->with('mensaje','Localidad actualizada con exito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $localidad = Localidad::find($id);
        $localidad->delete();

        return redirect('localidades')->with('mensaje','Localidad eliminada con exito.');
    }
}
