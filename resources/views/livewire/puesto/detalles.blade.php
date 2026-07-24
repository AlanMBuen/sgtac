<div>
    @if (session()->has('mensaje'))
        <div>
            {{ session('mensaje') }}
        </div>
    @endif

    <h2>Puesto {{ $puesto->nombre }}</h2>
    <p>Clave: {{ $puesto->clave }}</p>
    <p>Correo: {{ $puesto->descripcion ? $puesto->descripcion : 'Sin descripcion registrada' }}</p>

    <form wire:submit="crear">
        <h3>Crear Responsabilidad</h3>
        <div>
            <label>Responsabilidad</label>
            <input type="text" wire:model="responsabilidad">
            @error('responsabilidad') <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <select wire:model="dificultad">
                <option value="">-- Selecciona una dificultad (Opcional) --</option>
                <option value="baja">Baja</option>
                <option value="media">Media</option>
                <option value="alta">Alta</option>
            </select>
        </div>

        <button type="submit">{{ $editando_id ? 'Actualizar' : 'Crear' }}</button>

        @if ($editando_id)
            <button wire:click="cancelarEdicion">Cancelar</button>
        @endif
    </form>

    <div>
        <h3>Responsabilidad del {{ $puesto->nombre }}</h3>
        @forelse($responsabilidadespuestos as $responsabilidadespuesto)
            <hr>
            <div>
                <p>{{ $responsabilidadespuesto->dificultad }}
                    <span>{{ $responsabilidadespuesto->created_at->diffForHumans()}}</span>
                </p>
                <p>{{ $responsabilidadespuesto->responsabilidad }} </p>
                <button wire:click="editar({{ $responsabilidadespuesto->id }})">Editar</button>
                <button wire:click="eliminar({{ $responsabilidadespuesto->id }})">Eliminar</button>
            </div>
        @empty
            <p>Aún no hay Responsabilidades del {{ $puesto->nombre }}</p>
        @endforelse
    </div>
</div>
