<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Hash;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo = "Administrador de Usuarios";
        $items = User::all();
        return view("modules.usuarios.index", compact("titulo", "items"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo = 'Nuevo Usuario';
        return view('modules.usuarios.create', compact('titulo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //code...
            $item = new User();
            $item->name = $request->name;
            $item->email = $request->email;
            $item->password = Hash::make($request->password);
            $item->roles = $request->roles;
            $item->save();
    
            return to_route('usuarios.index')->with('success', 'Usuario creado correctamente');
        } catch (Exception $e) {
            return to_route('usuarios.index')->with('error', 'Error al crear el usuario');
        }
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
    public function edit(string $id)
    {
        $titulo = 'Editar Usuario';
        $item = User::find($id);
        return view('modules.usuarios.edit', compact('titulo', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $item = User::findOrFail($id);
            $item->name = $request->name;
            $item->email = $request->email;
            $item->roles = $request->roles;
            $item->save();
            return to_route('usuarios.index')->with('success','Usuario actualizado correctamente');
        } catch (Exception $e) {
            return to_route('usuarios.index')->with('error','Error al actualizar el usuario');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function tbody(Request $request)
    {
        $items = User::all();
        return view('modules.usuarios.tbody', compact('items'));
    }

    public function estado($id, $estado)
    {
        try {
            $item = User::findOrFail($id);
            $item->is_active = $estado;
            $item->save();
            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado'
            ], 500);
        }
    }

    public function cambiarPassword(Request $request)
    {
        try {
            $item = User::findOrFail($request->id);
            $item->password = Hash::make($request->password);
            $item->save();
            return response()->json([
                'success' => true,
                'message' => 'Contraseña cambiada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar la contraseña'
            ], 500);
        }
    }
}
