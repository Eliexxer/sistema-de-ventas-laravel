@extends('layouts.main')

@section('titulo', $titulo)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Listado de Categorias</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Editar Categoría</h5>
                            <form action="{{ route('categorias.update', $item->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre de la Categoría</label>
                                    <input type="text" class="form-control" required id="nombre" name="nombre"
                                        value="{{ $item->nombre }}">
                                </div>
                                <button type="submit" class="btn btn-warning mt-3">Actualizar</button>
                                <a href="{{ route('categorias.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection