@foreach ($items as $item)
    <tr class="text-center justify-content-center">
        <td>{{ $item->name }}</td>
        <td>{{ $item->email }}</td>
        <td>
            <!-- Checkbox con ID único y el ID del usuario en su value -->
            <input type="checkbox" id="{{ $item->id }}" value="{{ $item->id }}" class="check-estado d-none" {{ $item->is_active ? 'checked' : '' }} onchange="
                                                       const badge = this.nextElementSibling;
                                                       badge.classList.toggle('bg-success', this.checked);
                                                       badge.classList.toggle('bg-danger', !this.checked);
                                                       badge.textContent = this.checked ? 'Activo' : 'Inactivo';
                                                   ">

            <!-- El label actúa visualmente como el badge -->
            <label for="{{ $item->id }}" class="badge {{ $item->is_active ? 'bg-success' : 'bg-danger' }}"
                style="cursor: pointer; user-select: none;">
                {{ $item->is_active ? 'Activo' : 'Inactivo' }}
            </label>
        </td>

        <td>{{ $item->roles}}</td>
        <td>
            <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#cambiarPasswordModal" data-id="{{ $item->id }}">
                <i class="fa-solid fa-user-lock"></i>
            </a>
        </td>
        <td>
            <a class="btn btn-warning" href="{{ route('usuarios.edit', $item->id) }}">
                <i class="fa-solid fa-user-pen"></i>
            </a>
            <a class="btn btn-danger" href="">
                <i class="fa-solid fa-user-gear"></i>
            </a>
        </td>
    </tr>
@endforeach