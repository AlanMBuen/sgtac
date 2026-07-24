<?php

namespace App\Livewire\Puesto;

use App\Models\Puesto;
use App\Models\Responsabilidadespuesto;
use Livewire\Component;

class Detalles extends Component
{
    public Puesto $puesto;
    public string $puesto_id = '';
    public string $responsabilidad = '';
    public string $dificultad = '';
    public ?int $editando_id = null;

    public function mount(Puesto $puesto){
        $this->puesto_id = $puesto->id;
        $this->puesto = $puesto;
    }

    protected function rules(): array 
    {
        return [
            'puesto_id' => 'required|exists:puestos,id',
            'responsabilidad' => 'required|string|max:1000',
            'dificultad' => 'nullable|in:baja,media,alta',
        ];
    }

    public function crear()
    {
        $this->validate();

        $datos= [
            'puesto_id' => $this->puesto_id,
            'responsabilidad' => $this->responsabilidad,
            'dificultad' => $this->dificultad,
        ];

        if($this->editando_id){
            Responsabilidadespuesto::find($this->editando_id)->update($datos);
            session()->flash('mensaje','Responsabilidad editada correctamente');
        }else{
            Responsabilidadespuesto::create($datos);
            session()->flash('mensaje','Responsabilidad creada correctamente');
        }
    }

    public function editar(Responsabilidadespuesto $responsabilidadespuesto)
    {
        $this->editando_id = $responsabilidadespuesto->id;
        $this->responsabilidad = $responsabilidadespuesto->responsabilidad;
        $this->dificultad = $responsabilidadespuesto->dificultad;
        $this->puesto_id = $responsabilidadespuesto->puesto_id;
    }

    public function eliminar(Responsabilidadespuesto $responsabilidadespuesto)
    {
        $responsabilidadespuesto->delete();
        session()->flash('mensaje','Responsabilidad eliminada correctamente');
    }

    public function cancelarEdicion()
    {
        $this->reset(['editando_id', 'responsabilidad', 'dificultad']);
    }

    public function render()
    {
        return view('livewire.puesto.detalles',[
            'responsabilidadespuestos' => $this->puesto->responsabilidadespuestos,
        ]);
    }
}
