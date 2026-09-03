<form method="GET" action="{{ $action }}" class="row g-2 align-items-center mb-3">
    <!-- Filtro de cantidad de resultados -->
    <div class="col-12 col-md-auto d-flex align-items-center gap-2">
        <label for="cantidad" class="col-form-label text-secondary fw-semibold small mb-0">Mostrar:</label>
        <div class="input-group input-group-sm" style="max-width: 175px;">
            <input type="number" name="cantidad" id="cantidad" class="form-control text-center"
                value="{{ request('cantidad', 10) }}" min="1" max="20" required title="Mínimo 1, Máximo 20">
            <button type="submit" class="btn btn-outline-secondary" title="Filtrar cantidad de resultados">
                <i class="fa-solid fa-check"></i>
            </button>
            <span class="input-group-text bg-light text-muted small">registros</span>
        </div>
    </div>

    <!-- Buscador de texto y acciones -->
    <div class="col-12 col-md-7 col-lg-5 ms-md-auto">
        <div class="input-group input-group-sm">
            <input type="text" name="buscar" class="form-control" placeholder="{{ $placeholder ?? 'Buscar...' }}"
                value="{{ request('buscar') }}" aria-label="Buscar">
            <button type="submit" class="btn btn-primary" title="Buscar">
                <i class="fa-solid fa-magnifying-glass"></i> Buscar
            </button>
            @if(request()->filled('buscar') || (request()->filled('cantidad') && request('cantidad') != 10))
                <a href="{{ $action }}" class="btn btn-outline-danger" title="Limpiar filtros">
                    <i class="fa-solid fa-rotate-left"></i> Limpiar
                </a>
            @endif
        </div>
    </div>
</form>