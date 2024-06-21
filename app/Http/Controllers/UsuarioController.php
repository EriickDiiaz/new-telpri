<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Role::all();
        $usuarios = User::orderBy('name')->get();
        $totalUsuarios = User::count();
        return view('usuarios.index', compact('usuarios','totalUsuarios', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $errors = [
            'name.required' => 'Debes colocar el Nombre y Apellido.',
            'name.sting' => 'El Nombre y Apellido solo puede estar compuesto por letras.',
            'name.max' => 'Los Nombres y Apellidos no puede tener más de 255 caracteres.',
            'email.required' => 'Debes colocar el Usuario de red.',
            'email.sting' => 'El Usuario solo puede estar compuesto por letras y/o números.',
            'email.max' => 'El usuario no puede tener más de 10 caracteres.',
            'email.unique' =>'El usuario ya esta en uso',
            'password.required' => 'Debes colocar una Contraseña.',
            'password.confirmed' => 'Debes confirmar la Contraseña.',
            'password.sting' => 'El Nombre y Apellido solo puede estar compuesto por letras y/o números.',
            'password.max' => 'Los Nombres y Apellidos no puede tener más de 6 caracteres.'
        ];

        $request->validate([
            'name' =>'required', 'string', 'max:255',
            'email' =>'required', 'string', 'max:10', 'unique:users',
            'password' =>'required', 'string', 'min:6', 'confirmed'
        ],$errors);

        $usuario = new User();
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->password = Hash::make($request->input('password'));
        
        $usuario->save();

        return redirect ('usuarios')->with('mensaje','Usuario creado con exito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $usuario = User::find($id);
        $roles = Role::all();
        return view('usuarios.edit',compact('usuario', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $errors = [
            'name.required' => 'Debes colocar el Nombre y Apellido.',
            'name.sting' => 'El Nombre y Apellido solo puede estar compuesto por letras.',
            'name.max' => 'Los Nombres y Apellidos no puede tener más de 255 caracteres.',
            'email.required' => 'Debes colocar el Usuario de red.',
            'email.sting' => 'El Usuario solo puede estar compuesto por letras y/o números.',
            'email.max' => 'El usuario no puede tener más de 10 caracteres.',
            'email.unique' =>'El usuario ya esta en uso',
            'password.required' => 'Debes colocar una Contraseña.',
            'password.confirmed' => 'Debes confirmar la Contraseña.',
            'password.sting' => 'El Nombre y Apellido solo puede estar compuesto por letras y/o números.',
            'password.max' => 'Los Nombres y Apellidos no puede tener más de 6 caracteres.'
        ];

        $request->validate([
            'name' =>'required', 'string', 'max:255',
            'email' =>'required', 'string', 'max:10', 'unique:users',
            'password' =>'required', 'string', 'min:6', 'confirmed'
        ],$errors);

        $usuario = User::find($id);
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->roles()->sync($request->role);
        $usuario->password = Hash::make($request->input('password'));
        $usuario->save();

        return redirect ('/usuarios')->with('mensaje','Usuario actualizado con exito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $usuario = User::find($id);
        $usuario->delete();

        return redirect('usuarios')->with('mensaje','Usuario eliminado con exito.');
    }
}
