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
                            <h5 class="card-title">Administrar Productos</h5>
                            <p>Administrar los Productos</p>
                            <a href="#" class="btn btn-warning">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                Productos con Stock Minimo
                            </a>
                            <hr>
                            <a href="{{ route('productos.create') }}" class="btn btn-primary">
                                <i class="fa-solid fa-circle-plus"></i> Nuevo Producto
                            </a>
                            <hr>

                            @include('shared.table-filter', [
                                'action' => route('productos.index'),
                                'placeholder' => 'Buscar por nombre, categoría, proveedor...'
                            ])

                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Precio Compra</th>
                                            <th class="text-center">Precio Venta</th>
                                            <th class="text-center">Stock</th>
                                            <th class="text-center">Categoria</th>
                                            <th class="text-center">Proveedor</th>
                                            <th class="text-center">Activo</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($items as $item)
                                            <tr>
                                                <td class="text-center">{{ $item->nombre }}</td>
                                                <td class="text-center">{{ $item->descripcion }}</td>
                                                <td class="text-center">${{ number_format($item->precio_compra, 2) }}</td>
                                                <td class="text-center">${{ number_format($item->precio_venta, 2) }}</td>
                                                <td class="text-center">{{ $item->stock }}</td>
                                                <td class="text-center">{{ $item->category?->nombre ?? 'N/A' }}</td>
                                                <td class="text-center">{{ $item->proveedor?->nombre ?? 'N/A' }}</td>
                                                <td class="text-center">
                                                    <input type="checkbox" id="prod-{{ $item->id }}" value="{{ $item->id }}" class="check-estado d-none" {{ $item->activo ? 'checked' : '' }} onchange="
                                                        const badge = this.nextElementSibling;
                                                        badge.classList.toggle('bg-success', this.checked);
                                                        badge.classList.toggle('bg-danger', !this.checked);
                                                        badge.textContent = this.checked ? 'Activo' : 'Inactivo';
                                                    ">
                                                    <label for="prod-{{ $item->id }}" class="badge {{ $item->activo ? 'bg-success' : 'bg-danger' }}" style="cursor: pointer; user-select: none;" title="Clic para alternar estado">
                                                        {{ $item->activo ? 'Activo' : 'Inactivo' }}
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <a class="btn btn-warning btn-sm" href="{{ route('productos.edit', $item->id) }}" title="Editar producto">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <a class="btn btn-danger btn-sm" href="{{ route('productos.show', $item->id) }}" title="Eliminar producto">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-4 text-muted">
                                                    <i class="fa-solid fa-folder-open fs-3 d-block mb-2"></i>
                                                    No se encontraron productos
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

        function cambiar_estado(id, estado) {
            let url = "{{ route('productos.estado', ['id' => ':id', 'estado' => ':estado']) }}";
            url = url.replace(':id', id).replace(':estado', estado);
            $.ajax({
                type: "GET",
                url: url,
                success: function (response) {
                    if (response == 1 || (response && response.success)) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualizado!',
                            text: (response && response.message) ? response.message : 'Estado actualizado correctamente',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: (response && response.message) ? response.message : 'No se pudo actualizar el estado',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                },
                error: function (xhr) {
                    let msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Error de comunicación con el servidor';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: msg,
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        }

        $(document).on('change', '.check-estado', function () {
            let id = $(this).val();
            let estado = $(this).is(':checked') ? 1 : 0;
            cambiar_estado(id, estado);
        });
    </script>
@endpush