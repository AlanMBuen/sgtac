<div>
    @if (session()->has('mensaje'))
        <div>
            {{ session('mensaje') }}
        </div>
    @endif

    <h2>Ciudadano {{ $ciudadano->nombre }} {{ $ciudadano->apellido_paterno }}</h2>
    <p>CURP: {{ $ciudadano->curp ? $ciudadano->curp : 'Sin curp registrado' }}</p>
    <p>Correo: {{ $ciudadano->correo ? $ciudadano->correo : 'Sin correo registrado' }}</p>
    <p>Telefono: {{ $ciudadano->telefono ? $ciudadano->telefono : 'Sin telefono registrado' }}</p>
    <p>Direccion: {{ $ciudadano->direccion ? $ciudadano->direccion : 'Sin direccion registrado' }}</p>

    <form wire:submit="crear">
        <h3>Crear Nota</h3>
        <div>
            <label>Nota</label>
            <input type="text" wire:model="cuerpo">
            @error('cuerpo') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">{{ $editando_id ? 'Actualizar' : 'Crear' }}</button>

        @if ($editando_id)
            <button wire:click="cancelarEdicion">Cancelar</button>
        @endif
    </form>

    <div>
        <h3>Notas sobre {{ $ciudadano->nombre }} {{ $ciudadano->apellido_paterno }}</h3>
        @forelse($notaciudadanos as $notaciudadano)
            <hr>
            <div>
                <p>{{ $notaciudadano->cuerpo }}</p>
                <button wire:click="editar({{ $notaciudadano->id }})">Editar</button>
                <button wire:click="eliminar({{ $notaciudadano->id }})">Eliminar</button>
            </div>
        @empty
            <p>Aún no hay notas sobre {{ $ciudadano->nombre }} {{ $ciudadano->apellido_paterno }}</p>
        @endforelse
    </div>
</div>
