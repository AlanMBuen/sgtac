<?php

namespace App\Livewire\Tramite;

use App\Models\Ciudadano;
use App\Models\Empleado;
use App\Models\Tipotramite;
use App\Models\Tramite;
use Livewire\Component;

class Index extends Component
{
    public string $tipotramite_id = '';
    public string $ciudadano_id = '';
    public ?string $asignado_id = '';
    public string $folio = '';
    public string $estado = '';
    public string $fecha_limite = '';
    public ?int $editando_id = null;

    protected function rules(): array {
        return [
            'tipotramite_id' => 'required|exists:tipotramites,id',
            'ciudadano_id' => 'required|exists:ciudadanos,id',
            'asignado_id' => 'nullable|exists:asignados,id',
            'folio' => 'required|string|max:255|unique:tramites,folio' . $this->editando_id,
            'estado' => 'required|in:aprobado,rechazado,entregado',
            'fecha_limite' => 'required|date',
        ];
    }

    public function crear()
    {
        $this->validate();

        $datos = [
            'tipotramite_id' => $this->tipotramite_id,
            'ciudadano_id' => $this->ciudadano_id,
            'asignado_id' => $this->asignado_id,
            'folio' => $this->folio,
            'estado' => $this->estado,
            'fecha_limite' => $this->fecha_limite,
        ];

        if($this->editando_id){
            Tramite::find($this->editando_id)->update($datos);
            session()->flash('mensaje','Tramite editado');
        } else {
            Tramite::create($datos);
            session()->flash('mensaje','Tramite creado');
        }

        $this->cancelarEdicion();
    }

    public function editar(Tramite $tramite)
    {
        $this->editando_id = $tramite->id;
        $this->tipotramite_id = $tramite->tipotramite_id;
        $this->ciudadano_id = $tramite->ciudadano_id;
        $this->asignado_id = $tramite->asignado_id;
        $this->folio = $tramite->folio;
        $this->estado = $tramite->estado;
        $this->fecha_limite = $tramite->fecha_limite;
    }

    public function eliminar(Tramite $tramite)
    {
        $tramite->delete();
        session()->flash('mensaje','Tramite eliminado');
    }

    public function cancelarEdicion()
    {
        $this->reset(['editando_id', 'tipotramite_id', 'ciudadano_id', 'asignado_id', 'folio', 'estado', 'fecha_limite',]);
    }
    public function render()
    {
        return view('livewire.tramite.index',[
            'tramites' => Tramite::orderBy('nombre')->latest()->get(),
            'tipotramites' => Tipotramite::orderBy('nombre')->latest()->get(),
            'ciudadanos' => Ciudadano::orderBy('nombre')->latest()->get(),
            'asignado' => Empleado::orderBy('nombre')->latest()->get(),
        ]);
    }
}
