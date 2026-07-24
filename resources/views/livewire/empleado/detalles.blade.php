<div>
    @if (session()->has('mensaje'))
        <div>
            {{ session('mensaje') }}
        </div>
    @endif

    <h2>Empleado: {{ $empleado->nombre }} {{ $empleado->apellido_paterno }}</h2>
    <p>Correo: {{ $empleado->correo }}</p>
    <p>Telefono: {{ $empleado->telefono }}</p>
    <p>Sueldo: ${{ $empleado->sueldo }}</p>
    <p>Departamento: {{ $empleado->departamento->nombre }}</p>
    <p>Puesto: {{ $empleado->puesto->nombre }}</p>

    <form wire:submit="crear">
        <h3>Crear Nota</h3>
        <div>
            <label>Contenido</label>
            <input type="text" wire:model="contenido">
            @error('contenido') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">{{ $editando_id ? 'Actualizar' : 'Crear' }}</button>

        @if ($editando_id)
            <button wire:click="cancelarEdicion">Cancelar</button>
        @endif
    </form>

    <div>
        <h3>Nota sobre {{ $empleado->nombre }}</h3>
        @forelse($notaempleados as $notaempleado)
            <hr>
            <div>
                <p>{{ $notaempleado->contenido }}
                    <span>{{ $notaempleado->created_at->diffForHumans()}}</span>
                </p>
                <button wire:click="editar({{ $notaempleado->id }})">Editar</button>
                <button wire:click="eliminar({{ $notaempleado->id }})">Eliminar</button>
            </div>
        @empty
            <p>Aún no hay Notas sobre {{ $empleado->nombre }} {{ $empleado->apellido_paterno }}</p>
        @endforelse
    </div>
</div>
