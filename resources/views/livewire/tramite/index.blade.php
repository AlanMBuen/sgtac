<div>
    @if (session()->has('mensaje'))
        <div>
            {{ session('mensaje') }}
        </div>
    @endif

    <h2>Tramites</h2>

    <form wire:submit="crear">
        <h3>Crear un Tramite</h3>

        <div>
            <label>Tipo de tramite</label>
            <select wire:model="tipotramite_id">
                <option value="">-- Selecciona un Tipo de Tramite --</option>
                @foreach ($tipotramites as $tipotramite)
                    <option value="{{ $tipotramite->id }}">{{ $tipotramite->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Ciudadano del Tramite</label>
            <select wire:model="ciudadano_id">
                <option value="">-- Selecciona un Ciudadano --</option>
                @foreach ($ciudadanos as $ciudadano)
                    <option value="{{ $ciudadano->id }}">{{ $ciudadano->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Asignado a Realizar el Tramite</label>
            <select wire:model="asignado_id">
                <option value="">-- Selecciona un Empleado a realizar el Tramite --</option>
                @foreach ($asignados as $asignado)
                    <option value="{{ $asignado->id }}">{{ $asignado->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Folio del Tramite</label>
            <input type="text" wire:model="folio">
            @error('folio') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Fecha Limite para el tramite</label>
            <input type="date" wire:model="fecha_limite">
            @error('fecha_limite') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        @if ($editando_id)
            <div>
                <label>Estado del Tramite</label>
                <select wire:model="estado">
                    <option value="">-- Selecciona un Estado del Tramite --</option>
                    <option value="aprobado">Aprobado</option>
                    <option value="rechazado">Rechazado</option>
                    <option value="entregado">Entregado</option>
                </select>
            </div>
        @endif
        
        <button type="submit">{{ $editando_id ? 'Actualizar' : 'Crear' }}</button>

        @if ($editando_id)
            <button wire:click="cancelar">Cancelar</button>
        @endif
    </form>

    <hr>

    <div>
        <input type="text" wire:model.live="buscar" placeholder="Buscar por Folio, empleado o estudiante" class="form-control">
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Folio</th>
                <th>Ciudadano</th>
                <th>Fecha Limite del Tramite</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tramites as $tramite)
                <tr>
                    <td>{{ $tramite->folio }}</td>
                    <td>{{ $tramite->ciudadano->nombre }} {{ $tramite->ciudadano->apellido_paterno }}</td>
                    <td>{{ $tramite->fecha_limite }}</td>
                    <td>
                        <button wire:click="editar({{ $tramite->id }})">Editar</button>
                        <button wire:click="eliminar({{ $tramite->id }})">Eliminar</button>
                        <a href="{{ route('tramite.detalles', $tramite) }}">Mas detalles</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Aún no existen Tramites Registrados</td></tr>
            @endforelse
        </tbody>
    </table>

    <div>
        {{ $tramite->links() }}
    </div>
</div>
