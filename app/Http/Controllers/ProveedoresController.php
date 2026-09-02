<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Exception;
use Illuminate\Http\Request;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Proveedor::all();
        $titulo = 'Administrar Proveedores';
        return view("modules.proveedores.index", compact("titulo", "items"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo = 'Nuevo Proveedor';
        return view('modules.proveedores.create', compact('titulo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $item = new Proveedor();
            $item->nombre = $request->nombre;
            $item->telefono = $request->telefono;
            $item->email = $request->email;
            $item->cp = $request->cp;
            $item->sitio_web = $request->sitio_web;
            $item->notas = $request->notas;
            $item->save();

            return to_route('proveedores.index')->with('success', 'Proveedor creado correctamente');
        } catch (Exception $e) {
            return to_route('proveedores.index')->with('error', 'Error al crear el proveedor');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $titulo = 'Eliminar Proveedor';
        $item = Proveedor::findOrFail($id);
        return view('modules.proveedores.show', compact('titulo', 'item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $titulo = 'Editar Proveedor';
        $item = Proveedor::findOrFail($id);
        return view('modules.proveedores.edit', compact('titulo', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $item = Proveedor::findOrFail($id);
            $item->nombre = $request->nombre;
            $item->telefono = $request->telefono;
            $item->email = $request->email;
            $item->cp = $request->cp;
            $item->sitio_web = $request->sitio_web;
            $item->notas = $request->notas;
            $item->save();

            return to_route('proveedores.index')->with('success', 'Proveedor actualizado correctamente');
        } catch (Exception $e) {
            return to_route('proveedores.index')->with('error', 'Error al actualizar el proveedor');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = Proveedor::findOrFail($id);
            $item->delete();

            return to_route('proveedores.index')->with('success', 'Proveedor eliminado correctamente');
        } catch (Exception $e) {
            return to_route('proveedores.index')->with('error', 'Error al eliminar el proveedor');
        }
    }
}
