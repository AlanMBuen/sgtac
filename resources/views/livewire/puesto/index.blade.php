<div>
    @if (session()->has('mensaje'))
        <div>
            {{ session('mensaje') }}
        </div>
    @endif

    <h2>Puestos</h2>
    <form wire:submit="crear">
        <div>
            <label>Nombre</label>
            <input type="text" wire:model="nombre">
            @error('nombre') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Clave</label>
            <input type="text" wire:model="clave">
            @error('clave') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Descripcion</label>
            <input type="text" wire:model="descripcion">
            @error('descripcion') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">{{ $editando_id ? 'Actualizar' : 'Crear' }}</button>

        @if ($editando_id)
            <button wire:click="cancelarEdicion">Cancelar</button>
        @endif
    </form>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Clave</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($puestos as $puesto)
                <tr wire:key="{{ $puesto->id }}">
                    <td>{{ $puesto->nombre }}</td>
                    <td>{{ $puesto->clave }}</td>
                    <td>
                        <button wire:click="editar({{ $puesto->id }})">Editar</button>
                        <button wire:click="eliminar({{ $puesto->id }})">Eliminar</button>
                        <a href="{{ route('puestos.detalles', $puesto) }}">Mas detalles</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">Aún no existen puestos registrados</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
