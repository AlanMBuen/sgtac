<div>
    @if (session()->has('mensaje'))
        <div>
            {{ session('mensaje') }}
        </div>
    @endif

    <div>
        <h2>Folio del Tramite: {{ $tramite->folio }}</h2>
        <p>Tipo de Tramite: {{ $tramite->tipotramite->nombre }}</p>
        <p>Ciudadano del Tramite: {{ $tramite->ciudadano->nombre }} {{ $tramite->ciudadano->apellido_paterno }}</p>
        <p>Asignado a Realizar el tramite: {{ $tramite->asignado->nombre }} {{ $tramite->asignado->apellido_paterno }}</p>
        <p>Fecha Limite para realizar el Tramite: {{ $tramite->fecha_limite }}</p>
        <p>Estado del Tramite: {{ $tramite->estado }}</p>
    </div>

    <hr>

    <form wire:submit="crear">
        <h3>Crear Comentario sobre el Tramite</h3>

        <div>
            <label>Comentario</label>
            <input type="text" wire:model="mensaje">
            @error('mensaje') <span style="color:red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Empleado dueño del mensaje</label>
            <select wire:model="empleado_id">
                <option value="">-- Selecciona un Empleado --</option>
                @foreach ($empleados as $empleado)
                    <option value="{{ $empleado->id }}">{{ $empleado->nombre }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit">{{ $editando_id ? 'Actualizar' : 'Crear' }}</button>

        @if ($editando_id)
            <button wire:click="cancelarEdicion">Cancelar</button>
        @endif
    </form>

    <hr>

    <div>
        <h3>Comentarios sobre {{ $tramite->ciudadano->nombre }} {{ $tramite->ciudadano->apellido_paterno }}</h3>
        @forelse($comentariotramites as $comentariotramite)
            <div>
                <p> {{ $comentariotramite->mensaje }}
                    <span>{{ $comentariotramite->created_at->diffForHumans() }}</span>
                </p>
            </div>
        @empty
            <p>Aún no exiten sobre este tramite</p>
        @endforelse
    </div>
    
    <a href="{{ route('tramite.index') }}">Volver a Tramites</a>
</div>
