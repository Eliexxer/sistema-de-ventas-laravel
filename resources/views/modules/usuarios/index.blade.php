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
                                    @include("modules.usuarios.tbody")
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

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
        function recargar_tbody() {
            $.ajax({
                type: "GET",
                url: "{{ route('usuarios.tbody') }}",
                success: function (response) {
                    console.log(response);
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
                    if (response == 1) {
                        alert("Estado actualizado correctamente");
                        recargar_tbody();
                    }
                }
            });
        }

        function cambioPassword() {
            let id = $('#id_usuario').val();
            let password = $('#password').val();
            let confirmacion = $('#confirmacion_password').val();

            // 1. Validar que las contraseñas coincidan
            if (password !== confirmacion) {
                alert("Las contraseñas no coinciden. Por favor, verifícalas.");
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
                    if (response.success) {
                        // 2. Alerta de éxito
                        alert(response.message);

                        // 3. Limpieza del formulario
                        $('#frmPassword')[0].reset();

                        // 4. Cerrar el modal automáticamente
                        let modalElement = document.getElementById('cambiarPasswordModal');
                        let modalInstance = bootstrap.Modal.getInstance(modalElement);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    } else {
                        alert("Ocurrió un error al cambiar la contraseña.");
                    }
                },
                error: function (xhr) {
                    console.error(xhr);
                    alert("Error al procesar la solicitud.");
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