<div>
    <h2>Departamentos</h2>

    @if (session()->has('mensaje'))
        <div>
            {{ session('mensaje') }}
        </div>
    @endif

    <form wire:submit="crear">
        <div>
            <label>Nombre del Departamento</label>
            <input type="text" wire:model="nombre">
            @error('nombre') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Descripcion de Funciones del Departamento</label>
            <input type="text" wire:model="descripcion">
            @error('descripcion') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Direccion del Departamento</label>
            <input type="text" wire:model="direccion">
            @error('direccion') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">{{ $editando_id ? 'Actualizar' : 'Crear' }}</button>

        @if ($editando_id)
            <button wire:click="cancelarEdicion">Cancelar</button>
        @endif
    </form>

    <hr>

    <h3>Departamentos Activos</h3>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($departamentos as $departamento)
                <tr wire:key="{{ $departamento->id }}">
                    <td>{{ $departamento->nombre }}</td>
                    <td>
                        <button wire:click="editar({{ $departamento->id }})">Editar</button>
                        <button wire:click="eliminar({{ $departamento->id }})">Eliminar</button>
                        <a href="{{ route('departamentos.detalles', $departamento) }}">Mas detalles</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="2">Aún no existen departamentos registrados</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
