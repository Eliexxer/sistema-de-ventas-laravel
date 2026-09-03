@extends('layouts.main')

@section('titulo', $titulo)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Listado de Productos</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Crear Producto</h5>

                            <form action="{{ route('productos.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="form-label">Nombre del Producto</label>
                                        <input type="text" class="form-control" required id="nombre" name="nombre" placeholder="Ej: Laptop Dell XPS 15">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="category_id" class="form-label">Categoría</label>
                                        <select class="form-select" required id="category_id" name="category_id">
                                            <option value="" selected disabled>Seleccione una categoría</option>
                                            @foreach ($categorias as $categoria)
                                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="proveedor_id" class="form-label">Proveedor</label>
                                        <select class="form-select" required id="proveedor_id" name="proveedor_id">
                                            <option value="" selected disabled>Seleccione un proveedor</option>
                                            @foreach ($proveedores as $proveedor)
                                                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="stock" class="form-label">Stock Inicial</label>
                                        <input type="number" class="form-control" required id="stock" name="stock" min="0" value="0" placeholder="0">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="precio_compra" class="form-label">Precio de Compra</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" min="0" class="form-control" required id="precio_compra" name="precio_compra" value="0.00" placeholder="0.00">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="precio_venta" class="form-label">Precio de Venta</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" min="0" class="form-control" required id="precio_venta" name="precio_venta" value="0.00" placeholder="0.00">
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="descripcion" class="form-label">Descripción (Opcional)</label>
                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Detalles, especificaciones o notas del producto..."></textarea>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fa-solid fa-save"></i> Guardar Producto
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
