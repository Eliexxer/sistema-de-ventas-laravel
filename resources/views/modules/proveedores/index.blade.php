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
                            <h5 class="card-title">Administrar Proveedores</h5>
                            <p>Administrar los Proveedores</p>
                            <a href="{{ route('proveedores.create') }}" class="btn btn-primary">
                                <i class="fa-solid fa-circle-plus"></i> Nuevo Proveedor
                            </a>
                            <hr>

                            @include('shared.table-filter', [
                                'action' => route('proveedores.index'),
                                'placeholder' => 'Buscar por nombre, email, teléfono, ciudad...'
                            ])

                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Teléfono</th>
                                            <th>Email</th>
                                            <th>CP</th>
                                            <th>Sitio Web</th>
                                            <th>Notas</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($items as $item)
                                            <tr>
                                                <td>{{ $item->nombre }}</td>
                                                <td>{{ $item->telefono }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->cp }}</td>
                                                <td>{{ $item->sitio_web }}</td>
                                                <td>{{ $item->notas }}</td>
                                                <td class="text-center">
                                                    <a class="btn btn-warning btn-sm" href="{{ route('proveedores.edit', $item->id) }}">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <a class="btn btn-danger btn-sm" href="{{ route('proveedores.show', $item->id) }}">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4 text-muted">
                                                    <i class="fa-solid fa-folder-open fs-3 d-block mb-2"></i>
                                                    No se encontraron proveedores
                                                    @if(request('buscar'))
                                                        para "<strong>{{ request('buscar') }}</strong>"
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table with stripped rows -->

                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
                                <small class="text-muted">
                                    Mostrando {{ $items->firstItem() ?? 0 }} a {{ $items->lastItem() ?? 0 }} de {{ $items->total() }} registros
                                </small>
                                <div>
                                    {{ $items->links() }}
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection

@push('scripts')
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                confirmButtonText: 'Aceptar'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonText: 'Aceptar'
            });
        @endif
    </script>
@endpush