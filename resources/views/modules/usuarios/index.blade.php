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

                            @include('shared.table-filter', [
                                'action' => route('usuarios.index'),
                                'placeholder' => 'Buscar por nombre, email, rol...'
                            ])

                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr class="text-center justify-content-center">
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Estado</th>
                                            <th>Rol</th>
                                            <th>Acciones </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include("modules.usuarios.tbody")
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
    @include('modules.usuarios.modal_cambiar_password')
@endsection

@push('scripts')
    <script>
        // Alertas de sesión (crear / editar usuario)
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

        function recargar_tbody() {
            let urlParams = new URLSearchParams(window.location.search);
            let queryString = urlParams.toString();
            let url = "{{ route('usuarios.tbody') }}" + (queryString ? '?' + queryString : '');
            $.ajax({
                type: "GET",
                url: url,
                success: function (response) {
                    $('table tbody').html(response);
                }
            });
        }

        function cambiar_estado(id, estado) {
            let url = "{{ route('usuarios.estado', ['id' => ':id', 'estado' => ':estado']) }}";
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
                        recargar_tbody();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: (response && response.message) ? response.message : 'No se pudo actualizar el estado',
                            confirmButtonText: 'Aceptar'
                        });
                        recargar_tbody();
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
                    recargar_tbody();
                }
            });
        }

        function cambioPassword() {
            let id = $('#id_usuario').val();
            let password = $('#password').val();
            let confirmacion = $('#confirmacion_password').val();

            // 1. Validar que las contraseñas coincidan
            if (password !== confirmacion) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Las contraseñas no coinciden. Por favor, verifícalas.',
                    confirmButtonText: 'Aceptar'
                });
                return false;
            }

            let token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: "POST",
                url: "{{ route('usuarios.cambioPassword') }}",
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: {
                    id: id,
                    password: password
                },
                success: function (response) {
                    if (response == 1 || (response && response.success)) {
                        // 2. Alerta de éxito con SweetAlert2
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: (response && response.message) ? response.message : 'Contraseña actualizada correctamente',
                            confirmButtonText: 'Aceptar'
                        });

                        // 3. Limpieza del formulario
                        $('#frmPassword')[0].reset();

                        // 4. Cerrar el modal automáticamente
                        let modalElement = document.getElementById('cambiarPasswordModal');
                        let modalInstance = bootstrap.Modal.getInstance(modalElement);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: (response && response.message) ? response.message : 'Ocurrió un error al cambiar la contraseña.',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                },
                error: function (xhr) {
                    console.error(xhr);
                    let msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Error al procesar la solicitud en el servidor.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: msg,
                        confirmButtonText: 'Aceptar'
                    });
                }
            });

            return false;
        }

        $(document).on('change', '.check-estado', function () {
            let id = $(this).val();
            let estado = $(this).is(':checked') ? 1 : 0;
            cambiar_estado(id, estado);
        });

        $('#cambiarPasswordModal').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let id = button.data('id');
            $('#id_usuario').val(id);
            console.log("ID del usuario para cambiar password:", id);
        });

        $('#cambiarPasswordModal').on('hidden.bs.modal', function () {
            $('#frmPassword')[0].reset();
        });
    </script>
@endpush