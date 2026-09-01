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
                            <h5 class="card-title">Crear Usuario</h5>
                            <form action="{{ route('usuarios.store') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" required id="name" name="name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" required id="email" name="email">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" required id="password" name="password">
                                </div>
                                <div class="mb-3">
                                    <label for="roles" class="form-label">Rol de Usuario</label>
                                    <select class="form-select" required id="roles" name="roles">
                                        <option value="" disabled selected>Selecciona un rol</option>
                                        <option value="admin">Administrador</option>
                                        <option value="cajero">Cajero</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Crear</button>
                                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
