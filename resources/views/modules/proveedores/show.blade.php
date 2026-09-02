@extends('layouts.main')

@section('titulo', $titulo)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Eliminar Proveedor</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-danger">¿Estás seguro de que deseas eliminar este proveedor?</h5>
                            <p>Esta acción eliminará el registro de la base de datos de manera permanente.</p>

                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 250px;">Nombre del Proveedor</th>
                                        <td>{{ $item->nombre }}</td>
                                    </tr>
                                    <tr>
                                        <th>Teléfono</th>
                                        <td>{{ $item->telefono }}</td>
                                    </tr>
                                    <tr>
                                        <th>Correo Electrónico</th>
                                        <td>{{ $item->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Código Postal (CP)</th>
                                        <td>{{ $item->cp }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sitio Web</th>
                                        <td>{{ $item->sitio_web ?? 'No especificado' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Notas</th>
                                        <td>{{ $item->notas ?? 'Sin notas' }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <form action="{{ route('proveedores.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mt-3">
                                    <i class="fa-solid fa-trash"></i> Confirmar Eliminación
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
