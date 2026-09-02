<!-- Button trigger modal -->
<form id="frmPassword" onsubmit="return cambioPassword()">
    @csrf
    <div class="modal fade" id="cambiarPasswordModal" tabindex="-1" aria-labelledby="cambiarPasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="cambiarPasswordModalLabel">Cambiar Contraseña</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id_usuario">
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Contraseña Nueva
                        </label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Contraseña" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmacion_password" class="form-label">
                            Confirmar Contraseña
                        </label>
                        <input type="password" class="form-control" name="confirmacion_password"
                            id="confirmacion_password" required placeholder="Confirmar contraseña">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary">Cambiar contraseña</button>
                </div>
            </div>
        </div>
    </div>
</form>