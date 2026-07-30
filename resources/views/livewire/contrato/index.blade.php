<div>
    @if (session()->has('mensaje'))
        <div>
            {{ session('mensaje') }}
        </div>
    @endif

    <h2>Contratos</h2>
    <form wire:submit="crear">
        <div>
            <label>Empleado</label>
            <select wire:model="empleado_id">
                <option value="">Selecciona un empleado</option>
                @foreach ($empleados as $empleado)
                    <option value="{{ $empleado->id }}">{{ $empleado->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Periodo (Meses)</label>
            <input type="int" wire:model="periodo">
            @error('periodo') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Fecha de Inicio</label>
            <input type="date" wire:model="fecha_inicio">
            @error('fecha_inicio') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Fecha de Termino</label>
            <input type="date" wire:model="fecha_termino">
            @error('fecha_termino') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Estado Actual del Contrato</label>
            <select wire:model="estado">
                <option value="">Selecciona el estado del Contrato</option>
                <option value="activo">Activo</option>
                <option value="vencido">Vencido</option>
                <option value="evaluando">Evaluando</option>
            </select>
        </div>

        <button type="submit">{{ $editando_id ? 'Actualizar' : 'Crear' }}</button>

        @if ($editando_id)
            <button wire:click="cancelarEdicion">Cancelar</button>
        @endif
    </form>

    <hr>

    <input type="text" wire:model.live="buscar" placeholder="Buscar por empleado o estado" class="form-control">

    <table>
        <thead>
            <tr>
                <th>Empleado</th>
                <th>Periodo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contratos as $contrato)
                <tr wire:key="{{ $contrato->id }}">
                    <td>{{ $contrato->empleado->nombre }} {{ $contrato->empleado->apellido_paterno }}</td>
                    <td>{{ $contrato->periodo }}</td>
                    <td>{{ $contrato->estado }}</td>
                    <td>
                        <button wire:click="editar({{ $contrato->id }})">Editar</button>
                        <button wire:click="eliminar({{ $contrato->id }})">Eliminar</button>
                        <a href="{{ route('contratos.detalles', $empleado) }}">Mas detalles</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Aún no existen contratos registrados</td></tr>
            @endforelse
        </tbody>
    </table>

    <div>
        {{ $contratos->links() }}
    </div>
</div>
