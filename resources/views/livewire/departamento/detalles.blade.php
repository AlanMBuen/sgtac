<div>
    <h2>Departamento: {{ $departamento->nombre }}</h2>
    <p>Descripcion de Funciones: {{ $departamento->descripcion }}</p>
    <p>Direccion del Departamento: {{ $departamento->direccion }}</p>

    <hr>

    <form wire:submit="crear">
        <h3>Creacion de Etiqueta sobre El Departamento</h3>

        <div>
            <label>Etiqueta</label>
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
        <h3>Lista de Etiquetas</h3>
        @forelse($etiquetadepartamentos as $etiquetadepartamento)
            <div>
                <p>{{ $etiquetadepartamento->contenido }}</p>
                <button wire:click="editar({{ $etiquetadepartamento->id }})">Editar</button>
                <button wire:click="eliminar({{ $etiquetadepartamento->id }})">Eliminar</button>
            </div>
        @empty
            <p>Aún no existen Etiquetas de este departamento</p>
        @endforelse
    </div>

    <a href="{{ route('departamentos.index') }}">Volver a vista Departamentos</a>
</div>
