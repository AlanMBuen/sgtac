<?php

namespace App\Livewire\Departamento;

use App\Models\Departamento;
use App\Models\Etiquetadepartamento;
use Livewire\Component;

class Detalles extends Component
{
    public Departamento $departamento;
    public string $contenido = '';
    public string $departamento_id = '';
    public ?int $editando_id = null;

    public function mount(Departamento $departamento)
    {
        $this->departamento = $departamento;
        $this->departamento_id= $departamento->id;
    }
    
    protected function rules(): array
    {
        return [
            'departamento_id' => 'required|exists:departamentos,id',
            'contenido' => 'required|string|max:1000',
        ];
    }

    public function crear()
    {
        $this->validate();

        $datos = [
            'departamento_id' => $this->departamento_id,
            'contenido' => $this->contenido
        ];

        if($this->editando_id){
            Etiquetadepartamento::find($this->editando_id)->update($datos);
            session()->flash('mensaje','Etiqueta editada correctamente');
        } else {
            Etiquetadepartamento::create($datos);
            session()->flash('mensaje','Etiqueta creada correctamente');
        }

        $this->cancelarEdicion();
    }

    public function editar(Etiquetadepartamento $etiquetadepartamento)
    {
        $this->editando_id = $etiquetadepartamento->id;
        $this->contenido = $etiquetadepartamento->contenido;
        $this->departamento_id = $etiquetadepartamento->departamento_id;
    }

    public function eliminar(Etiquetadepartamento $etiquetadepartamento)
    {
        $etiquetadepartamento->delete();
        session()->flash('mensaje','Etiqueta eliminada correctamente');
    }

    public function cancelarEdicion()
    {
        $this->reset(['editando_id', 'contenido']);
        session()->flash('mensaje','Etiqueta eliminada correctamente');
    }

    public function render()
    {
        return view('livewire.departamento.detalles',[
            'etiquetadepartamentos' => $this->departamento->etiquetadepartamentos,
        ]);
    }
}
