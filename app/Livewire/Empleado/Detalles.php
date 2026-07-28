<?php

namespace App\Livewire\Empleado;

use App\Models\Empleado;
use App\Models\Notaempleado;
use Livewire\Component;

class Detalles extends Component
{
    public Empleado $empleado;
    public string $empleado_id = '';
    public string $contenido = '';
    public ?int $editando_id = null;

    public function mount(Empleado $empleado){
        $this->empleado_id = $empleado->id;
        $this->empleado = $empleado;
    }

    protected function rules(): array 
    {
        return [
            'empleado_id' => 'required|exists:empleados,id',
            'contenido' => 'required|string|max:1000',
        ];
    }

    public function crear()
    {
        $this->validate();

        $datos= [
            'empleado_id' => $this->empleado_id,
            'contenido' => $this->contenido,
        ];

        if($this->editando_id){
            Notaempleado::find($this->editando_id)->update($datos);
            session()->flash('mensaje','Nota editada correctamente');
        }else{
            Notaempleado::create($datos);
            session()->flash('mensaje','Nota creada correctamente');
        }

        $this->cancelarEdicion();
    }

    public function editar(Notaempleado $notaempleado)
    {
        $this->editando_id = $notaempleado->id;
        $this->contenido = $notaempleado->contenido;
        $this->empleado_id = $notaempleado->empleado_id;
    }

    public function eliminar(Notaempleado $notaempleado)
    {
        $notaempleado->delete();
        session()->flash('mensaje','Nota eliminada correctamente');
    }

    public function cancelarEdicion()
    {
        $this->reset(['editando_id', 'contenido']);
    }

    public function render()
    {
        return view('livewire.empleado.detalles',[
            'notaempleados' => $this->empleado->notaempleados,
        ]);
    }
}
