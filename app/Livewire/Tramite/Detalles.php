<?php

namespace App\Livewire\Tramite;

use App\Models\Comentariotramite;
use App\Models\Empleado;
use App\Models\Tramite;
use Livewire\Component;

class Detalles extends Component
{
    public Tramite $tramite;
    public string $tramite_id = '';
    public string $empleado_id = '';
    public string $mensaje = '';
    public ?int $editando_id = null;

    public function mount(Tramite $tramite){
        $this->tramite_id = $tramite->id;
        $this->tramite = $tramite;
    }

    protected function rules(): array {
        return [
            'tramite_id' => 'required|exists:tramites,id',
            'empleado_id' => 'required|exists:empleados,id',
            'mensaje' => 'required|string|max:1000'
        ];
    }

    public function crear()
    {
        $this->validate();

        $datos = [
            'tramite_id' => $this->tramite_id,
            'empleado_id' => $this->empleado_id,
            'mensaje' => $this->mensaje
        ];

        if($this->editando_id){
            Comentariotramite::find($this->editando_id)->update($datos);
            session()->flash('mensaje', 'Comentario del tramite editado');
        } else {
            Comentariotramite::create($datos);
            session()->flash('mensaje', 'Comentario del tramite creado');
        }

        $this->cancelarEdicion();
    }

    public function editar(Comentariotramite $comentariotramite)
    {
        $this->editando_id = $comentariotramite->id;
        $this->tramite_id = $comentariotramite->tramite_id;
        $this->empleado_id = $comentariotramite->empleado_id;
        $this->mensaje = $comentariotramite->mensaje;
    }

    public function eliminar(Comentariotramite $comentariotramite)
    {
        $comentariotramite->delete();
        session()->flash('mensaje', 'Comentario del tramite eliminado');
    }

    public function cancelarEdicion()
    {
        $this->reset(['editando_id', 'mensaje', 'empleado_id']);
    }

    public function render()
    {
        return view('livewire.tramite.detalles',[
            'comentariotramites' => $this->tramite->comentariotramites,
            'empleados' => Empleado::orderBy('nombre')->latest()->get(),
        ]);
    }
}
