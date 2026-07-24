<div>
    @if (session()->has('mensaje'))
        <div>
            {{ session('mensaje') }}
        </div>
    @endif

    <h2>Empleados</h2>
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
            <label>Sueldo</label>
            <input type="int" wire:model="sueldo">
            @error('sueldo') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Departamento</label>
            <select wire:model="departamento_id">
                <option value="">Selecciona un Departamento</option>
                @foreach ($departamentos as $departamento)
                    <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Puestos</label>
            <select wire:model="puesto_id">
                <option value="">Selecciona un Puesto</option>
                @foreach ($puestos as $puesto)
                    <option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>
                @endforeach
            </select>
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
                <th>Correo</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($empleados as $empleado)
                <tr wire:key="{{ $empleado->id }}">
                    <td>{{ $empleado->nombre }} {{ $empleado->apellido_paterno }}</td>
                    <td>{{ $empleado->correo }}</td>
                    <td>{{ $empleado->telefono }}</td>
                    <td>
                        <button wire:click="editar({{ $empleado->id }})">Editar</button>
                        <button wire:click="eliminar({{ $empleado->id }})">Eliminar</button>
                        <a href="{{ route('empleados.detalles', $empleado) }}">Mas detalles</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Aún no existen empleados registrados</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
