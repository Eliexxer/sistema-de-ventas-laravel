<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $titulo = "Listado de Productos";
        $buscar = $request->input('buscar');
        $cantidad = (int) $request->input('cantidad', 10);
        $cantidad = max(1, min(20, $cantidad ?: 10));

        $items = Producto::with(['category', 'proveedor'])
            ->when($buscar, function ($query, $buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('descripcion', 'like', "%{$buscar}%")
                        ->orWhere('precio_venta', 'like', "%{$buscar}%")
                        ->orWhere('precio_compra', 'like', "%{$buscar}%")
                        ->orWhere('stock', 'like', "%{$buscar}%")
                        ->orWhereHas('category', function ($sub) use ($buscar) {
                            $sub->where('nombre', 'like', "%{$buscar}%");
                        })
                        ->orWhereHas('proveedor', function ($sub) use ($buscar) {
                            $sub->where('nombre', 'like', "%{$buscar}%");
                        });
                });
            })
            ->paginate($cantidad)
            ->withQueryString();

        return view("modules.productos.index", compact("titulo", "items"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo = "Nuevo Producto";
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view("modules.productos.create", compact("titulo", "categorias", "proveedores"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $item = new Producto();
            $item->user_id = Auth::id();
            $item->category_id = $request->category_id;
            $item->proveedor_id = $request->proveedor_id;
            $item->nombre = $request->nombre;
            $item->descripcion = $request->descripcion;
            $item->precio_compra = $request->precio_compra ?? 0;
            $item->precio_venta = $request->precio_venta ?? 0;
            $item->stock = $request->stock ?? 0;
            $item->activo = $request->has('activo') ? (bool) $request->activo : true;
            $item->save();

            return to_route('productos.index')->with('success', 'Producto creado correctamente');
        } catch (Exception $e) {
            return to_route('productos.index')->with('error', 'Error al crear el producto');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $titulo = "Eliminar Producto";
        $item = Producto::with(['category', 'proveedor'])->findOrFail($id);
        return view("modules.productos.show", compact("titulo", "item"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $titulo = "Editar Producto";
        $item = Producto::findOrFail($id);
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view("modules.productos.edit", compact("titulo", "item", "categorias", "proveedores"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $item = Producto::findOrFail($id);
            $item->category_id = $request->category_id;
            $item->proveedor_id = $request->proveedor_id;
            $item->nombre = $request->nombre;
            $item->descripcion = $request->descripcion;
            $item->precio_compra = $request->precio_compra ?? 0;
            $item->precio_venta = $request->precio_venta ?? 0;
            $item->stock = $request->stock ?? 0;
            if ($request->has('activo')) {
                $item->activo = (bool) $request->activo;
            }
            $item->save();

            return to_route('productos.index')->with('success', 'Producto actualizado correctamente');
        } catch (Exception $e) {
            return to_route('productos.index')->with('error', 'Error al actualizar el producto');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = Producto::findOrFail($id);
            $item->delete();

            return to_route('productos.index')->with('success', 'Producto eliminado correctamente');
        } catch (Exception $e) {
            return to_route('productos.index')->with('error', 'Error al eliminar el producto');
        }
    }

    /**
     * Cambiar estado activo/inactivo del producto vía AJAX.
     */
    public function estado($id, $estado)
    {
        try {
            $item = Producto::findOrFail($id);
            $item->activo = (bool) $estado;
            $item->save();

            return response()->json([
                'success' => true,
                'message' => 'Estado del producto actualizado correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado del producto'
            ], 500);
        }
    }
}
