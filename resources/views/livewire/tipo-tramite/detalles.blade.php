<div>
    @if (session()->has('mensaje'))
        <div>
            {{ session('mensaje') }}
        </div>
    @endif

    <div>
        <h2>Tipo de Tramite: {{ $tipotramite->nombre }}</h2>
        <p>Descripcion de estos tramites: {{ $tipotramite->descripcion }}</p>
        <p>Duracion de estos tramites: {{ $tipotramite->duracion ? $tipotramite->duracion . ' dias' : 'Sin duracion establecida' }}</p>
        <p>Departamento de realizacion de estos tramites: {{ $tipotramite->departamento->nombre }}</p>
    </div>

    <hr>

    <form wire:submit="crear">
        <h3>Crear Nota sobre el Tipo de Tramite</h3>

        <div>
            <label>Nota</label>
            <input type="text" wire:model="contenido">
            @error('contenido') <span style="color:red">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">{{ $editando_id ? 'Actualizar' : 'Crear' }}</button>

        @if ($editando_id)
            <button wire:click="cancelarEdicion">Cancelar</button>
        @endif
    </form>

    <hr>

    <div>
        <h3>Notas sobre {{ $tipotramite->nombre }}</h3>
        @forelse($notatipotramites as $notatipotramite)
            <div>
                <p> {{ $notatipotramite->contenido }}
                    <span>{{ $notatipotramite->created_at->diffForHumans() }}</span>
                </p>
            </div>
        @empty
            <p>Aún no exiten sobre este tipo de tramite</p>
        @endforelse
    </div>
    
    <a href="{{ route('tipotramites.index') }}">Volver a Tipos de Tramites</a>
</div>
