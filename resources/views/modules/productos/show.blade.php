@extends('layouts.main')

@section('titulo', $titulo)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Eliminar Producto</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-danger">¿Estás seguro de que deseas eliminar este producto?</h5>
                            <p>Esta acción eliminará el registro de la base de datos de manera permanente.</p>

                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 250px;">Nombre del Producto</th>
                                        <td>{{ $item->nombre }}</td>
                                    </tr>
                                    <tr>
                                        <th>Categoría</th>
                                        <td>{{ $item->category?->nombre ?? 'Sin categoría' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Proveedor</th>
                                        <td>{{ $item->proveedor?->nombre ?? 'Sin proveedor' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Stock</th>
                                        <td>{{ $item->stock }}</td>
                                    </tr>
                                    <tr>
                                        <th>Precio de Compra</th>
                                        <td>${{ number_format($item->precio_compra, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Precio de Venta</th>
                                        <td>${{ number_format($item->precio_venta, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Estado</th>
                                        <td>
                                            <span class="badge {{ $item->activo ? 'bg-success' : 'bg-danger' }}">
                                                {{ $item->activo ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Descripción</th>
                                        <td>{{ $item->descripcion ?? 'Sin descripción' }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <form action="{{ route('productos.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mt-3">
                                    <i class="fa-solid fa-trash"></i> Confirmar Eliminación
                                </button>
                                <a href="{{ route('productos.index') }}" class="btn btn-secondary mt-3">
                                    Cancelar
                                </a>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
