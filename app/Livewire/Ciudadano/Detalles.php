<?php

namespace App\Livewire\Ciudadano;

use App\Models\Ciudadano;
use App\Models\Notaciudadano;
use Livewire\Component;

class Detalles extends Component
{
    public Ciudadano $ciudadano;
    public string $ciudadano_id = '';
    public string $cuerpo = '';
    public ?int $editando_id = null;

    public function mount(Ciudadano $ciudadano){
        $this->ciudadano = $ciudadano;
        $this->ciudadano_id = $ciudadano->id;
    }

    protected function rules(): array 
    {
        return [
            'cuerpo' => 'required|string|max:1000',
            'ciudadano_id' => 'required|exists:ciudadanos,id'
        ];
    }

    public function crear()
    {
        $this->validate();

        $datos= [
            'cuerpo' => $this->cuerpo,
            'ciudadano_id' => $this->ciudadano_id
        ];

        if($this->editando_id){
            Notaciudadano::find($this->editando_id)->update($datos);
            session()->flash('mensaje','Nota editada correctamente');
        }else{
            Notaciudadano::create($datos);
            session()->flash('mensaje','Nota creada correctamente');
        }

        $this->cancelarEdicion();
    }

    public function editar(Notaciudadano $notaciudadano)
    {
        $this->editando_id = $notaciudadano->id;
        $this->cuerpo = $notaciudadano->cuerpo;
        $this->ciudadano_id = $notaciudadano->ciudadano_id;
    }

    public function eliminar(Notaciudadano $notaciudadano)
    {
        $notaciudadano->delete();
        session()->flash('mensaje','Nota eliminada correctamente');
    }

    public function cancelarEdicion()
    {
        $this->reset(['editando_id', 'cuerpo']);
    }

    public function render()
    {
        return view('livewire.ciudadano.detalles',[
            'notaciudadanos' => $this->ciudadano->notaciudadanos,
        ]);
    }
}
