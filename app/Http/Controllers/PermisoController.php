<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permisos = Permission::all();
    
        return view('permisos.index', compact('permisos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permisos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $permiso = Permission::create(['name' => $request->input('name')]);
        return redirect ('permisos')->with('mensaje','Permiso guardado con exito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permiso = Permission::find($id);
        return view('permisos.edit',['permiso'=>$permiso]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $permiso = Permission::find($id);
        $permiso->name = $request->input('name');
        $permiso->save();

        return redirect ('permisos')->with('mensaje','Permiso actualizado con exito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $permiso = Permission::find($id);
        $permiso->delete();

        return redirect('permisos')->with('mensaje','Permiso eliminado con exito.');
    }
}
