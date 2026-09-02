<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Auth;
use Exception;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo = "Administrar tus Categorias";
        $items = Categoria::all();
        return view('modules.categorias.index', compact('titulo', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $titulo = 'Nueva Categoría';
        return view('modules.categorias.create', compact('titulo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $item = new Categoria();
            $item->nombre = $request->nombre;
            $item->user_id = Auth::user()->id;
            $item->save();
            return to_route('categorias.index')->with('success', 'Categoria creada correctamente');
        } catch (Exception $e) {
            return to_route('categorias.index')->with('error', 'Error al crear la categoria');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $titulo = 'Eliminar Categoría';
        $item = Categoria::findOrFail($id);
        return view('modules.categorias.show', compact('titulo', 'item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $titulo = 'Editar Categoría';
        $item = Categoria::findOrFail($id);
        return view('modules.categorias.edit', compact('titulo', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $item = Categoria::findOrFail($id);
            $item->nombre = $request->nombre;
            $item->save();
            return to_route('categorias.index')->with('success', 'Categoria actualizada correctamente');
        } catch (Exception $e) {
            return to_route('categorias.index')->with('error', 'Error al actualizar la categoria');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Categoria::findOrFail($id);
        $item->delete();
        return redirect()->route('categorias.index');
    }
}
