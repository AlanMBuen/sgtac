<div>
    @if (session()->has('mensaje'))
        <div>
            {{ session('mensaje') }}
        </div>
    @endif

    <h2>Tipos de Tramites</h2>

    <form wire:submit="crear">
        <h3>Crear un Tipo de Tramite</h3>

        <div>
            <label>Nombre del Tipo de Tramite</label>
            <input type="text" wire:model="nombre">
            @error('nombre') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Descripción de estos tramites</label>
            <input type="text" wire:model="descripcion">
            @error('descripcion') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Duracion en dias de estos tramites</label>
            <input type="int" wire:model="duracion">
            @error('duracion') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Departamento</label>
            <select wire:model="departamento_id">
                <option value="">-- Selecciona un departamento --</option>
                @foreach ($departamentos as $departamento)
                    <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit">{{ $editando_id ? 'Actualizar' : 'Crear' }}</button>

        @if ($editando_id)
            <button wire:click="cancelar">Cancelar</button>
        @endif
    </form>

    <hr>
    
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Duracion</th>
                <th>Departamento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tipotramites as $tipotramite)
                <tr>
                    <td>{{ $tipotramite->nombre }}</td>
                    <td>{{ $tipotramite->duracion ? $tipotramite->duracion . ' dias' : 'Sin duracion establecida' }}</td>
                    <td>{{ $tipotramite->departamento->nombre }}</td>
                    <td>
                        <button wire:click="editar({{ $tipotramite->id }})">Editar</button>
                        <button wire:click="eliminar({{ $tipotramite->id }})">Eliminar</button>
                        <a href="{{ route('tipotramites.detalles', $tipotramite) }}">Mas detalles</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Aún no existen Tipos de Tramite Registrados</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
