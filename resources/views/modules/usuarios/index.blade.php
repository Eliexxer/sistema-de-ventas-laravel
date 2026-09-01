@extends('layouts.main')

@section('titulo', $titulo)

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Listado de Usuarios</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Administrar Usuarios</h5>
                            <p>Administrar los Usuarios</p>
                            <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
                                <i class="fa-solid fa-user-plus"></i> Nuevo Usuario
                            </a>
                            <hr>
                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr class="text-center justify-content-center">
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Estado</th>
                                        <th>Rol</th>
                                        <th>Cambio Contraseña</th>
                                        <th>Acciones </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr class="text-center justify-content-center">
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                @if ($item->is_active)
                                                    <span class="badge bg-success">Activo</span>
                                                @else
                                                    <span class="badge bg-danger">Inactivo</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->roles}}</td>
                                            <td>
                                                <a class="btn btn-primary" href="">
                                                    <i class="fa-solid fa-user-lock"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-warning" href="">
                                                    <i class="fa-solid fa-user-pen"></i>
                                                </a>
                                                <a class="btn btn-danger" href="">
                                                    <i class="fa-solid fa-user-gear"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection