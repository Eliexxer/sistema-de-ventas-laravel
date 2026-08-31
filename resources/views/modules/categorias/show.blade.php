@extends('layouts.main')

@section('titulo', $titulo)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Eliminar Categoría</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-danger">¿Estás seguro de que deseas eliminar esta categoría?</h5>
                            <p>Esta acción eliminará el registro de la base de datos de manera permanente.</p>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nombre de la Categoría</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $item->nombre }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <form action="{{ route('categorias.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mt-3">
                                    <i class="fa-solid fa-trash"></i> Confirmar Eliminación
                                </button>
                                <a href="{{ route('categorias.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
