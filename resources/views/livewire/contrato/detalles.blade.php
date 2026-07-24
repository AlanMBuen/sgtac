<div>
    @if (session()->has('mensaje'))
        <div>
            {{ session('mensaje') }}
        </div>
    @endif

    <h2>Contrato de {{ $contrato->empleado->nombre }} {{ $contrato->empleado->apellido_paterno }}</h2>
    <p>Periodo del Contrato: {{ $contrato->periodo }} meses</p>
    <p>Fecha de Inicio del Contrato: {{ $contrato->fecha_inicio }}</p>
    <p>Fecha de Termino del Contrato: {{ $contrato->fecha_termino }}</p>
    <p>Estado Actual del Contrato: {{ $contrato->estado }}</p>
</div>
