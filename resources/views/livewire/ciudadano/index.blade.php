<div>
    @if (session()->has('mensaje'))
        <div>
            {{ session('mensaje') }}
        </div>
    @endif

    <h2>Ciudadanos</h2>
    <form wire:submit="crear">
        <div>
            <label>Nombre</label>
            <input type="text" wire:model="nombre">
            @error('nombre') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Apellido Paterno</label>
            <input type="text" wire:model="apellido_paterno">
            @error('apellido_paterno') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Apellido Materno</label>
            <input type="text" wire:model="apellido_materno">
            @error('apellido_materno') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>CURP</label>
            <input type="text" wire:model="curp">
            @error('curp') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Correo</label>
            <input type="text" wire:model="correo">
            @error('correo') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Telefono</label>
            <input type="text" wire:model="telefono">
            @error('telefono') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Direccion</label>
            <input type="text" wire:model="direccion">
            @error('direccion') <span style="color: red">{{ $message }}</span>
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
                <th>CURP</th>
                <th>Correo</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ciudadanos as $ciudadano)
                <tr wire:key="{{ $ciudadano->id }}">
                    <td>{{ $ciudadano->nombre }} {{ $ciudadano->apellido_paterno }}</td>
                    <td>{{ $ciudadano->curp ? $ciudadano->curp : 'Sin CURP registrado'}}</td>
                    <td>{{ $ciudadano->correo ? $ciudadano->correo : 'Sin correo registrado'}}</td>
                    <td>{{ $ciudadano->telefono ? $ciudadano->telefono : 'Sin telefono registrado'}}</td>
                    <td>
                        <button wire:click="editar({{ $ciudadano->id }})">Editar</button>
                        <button wire:click="eliminar({{ $ciudadano->id }})">Eliminar</button>
                        <a href="{{ route('ciudadanos.detalles', $ciudadano) }}">Mas detalles</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Aún no existen ciudadanos registrados</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
