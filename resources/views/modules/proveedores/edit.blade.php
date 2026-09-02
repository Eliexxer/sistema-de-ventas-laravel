@extends('layouts.main')

@section('titulo', $titulo)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Listado de Proveedores</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Editar Proveedor</h5>

                            <form action="{{ route('proveedores.update', $item->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="form-label">Nombre del Proveedor</label>
                                        <input type="text" class="form-control" required id="nombre" name="nombre"
                                            value="{{ $item->nombre }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="text" class="form-control" required id="telefono" name="telefono"
                                            value="{{ $item->telefono }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Correo Electrónico</label>
                                        <input type="email" class="form-control" required id="email" name="email"
                                            value="{{ $item->email }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="cp" class="form-label">Código Postal (CP)</label>
                                        <input type="text" class="form-control" required id="cp" name="cp"
                                            value="{{ $item->cp }}">
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="sitio_web" class="form-label">Sitio Web (Opcional)</label>
                                        <input type="text" class="form-control" id="sitio_web" name="sitio_web"
                                            value="{{ $item->sitio_web }}">
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="notas" class="form-label">Notas Adicionales (Opcional)</label>
                                        <textarea class="form-control" id="notas" name="notas" rows="3">{{ $item->notas }}</textarea>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-warning mt-3">
                                    <i class="fa-solid fa-pen-to-square"></i> Actualizar Proveedor
                                </button>
                                <a href="{{ route('proveedores.index') }}" class="btn btn-secondary mt-3">
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
