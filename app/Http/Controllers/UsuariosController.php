<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $item = new User();
        $item->name = $request->name;
        $item->email = $request->email;
        $item->password = Hash::make($request->password);
        $item->roles = $request->roles;
        $item->save();

        return redirect()->route('usuarios.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
