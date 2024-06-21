<?php

namespace App\Http\Controllers;

use App\Models\Campo;
use Illuminate\Http\Request;

class CampoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $campos = Campo::orderBy('nombre')->get();
        $totalCampo = Campo::count();

        $busqueda = $request->busqueda;
        $camposQuery = Campo::query()
                    ->orderBy('nombre')
                    ->where('nombre', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('descripcion', 'LIKE', '%'.$busqueda.'%');
        $campos = $camposQuery->paginate(50);

        return view('campos.index', compact('campos','busqueda','totalCampo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('campos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $errors = [
            'nombre.required' => 'El Nombre del campo es obligatorio.',
            'descripcion.required' => 'La Descripcion del campo es obligatorio.'
        ];

        $request->validate([
            'nombre' =>'required',
            'descripcion' =>'required'
        ],$errors);

        $campo = new Campo();
        $campo->nombre = $request->input('nombre');
        $campo->descripcion = $request->input('descripcion');
        $campo->save();

        return redirect ('campos')->with('mensaje','Campo guardado con exito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Campo $campo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $campo = Campo::find($id);
        return view('campos.edit',['campo'=>$campo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $errors = [
            'nombre.required' => 'El Nombre del campo es obligatorio.',
            'descripcion.required' => 'La Descripcion del campo es obligatorio.'
        ];

        $request->validate([
            'nombre' =>'required',
            'descripcion' =>'required'
        ],$errors);

        $campo = Campo::find($id);
        $campo->nombre = $request->input('nombre');
        $campo->descripcion = $request->input('descripcion');
        $campo->save();

        return redirect ('campos')->with('mensaje','Campo actualizado con exito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $campo = Campo::find($id);
        $campo->delete();

        return redirect('campos')->with('mensaje','Campo eliminado con exito.');
    }
}
