<?php

namespace App\Livewire\TipoTramite;

use App\Models\Notatipotramite;
use App\Models\Tipotramite;
use Livewire\Component;

class Detalles extends Component
{
    public Tipotramite $tipotramite;
    public string $tipotramite_id = '';
    public string $contenido = '';
    public ?int $editando_id = null;

    public function mount(Tipotramite $tipotramite){
        $this->tipotramite_id = $tipotramite->id;
        $this->tipotramite = $tipotramite;
    }

    protected function rules(): array {
        return [
            'tipotramite_id' => 'required|exists:tipotramites,id',
            'contenido' => 'required|string|max:1000'
        ];
    }

    public function crear()
    {
        $this->validate();

        $datos = [
            'tipotramite_id' => $this->tipotramite_id,
            'contenido' => $this->contenido
        ];

        if($this->editando_id){
            Notatipotramite::find($this->editando_id)->update($datos);
            session()->flash('mensaje', 'Nota del Tipo de tramite editado');
        } else {
            Notatipotramite::create($datos);
            session()->flash('mensaje', 'Nota del Tipo de tramite creado');
        }

        $this->cancelarEdicion();
    }

    public function editar(Notatipotramite $notatipotramite)
    {
        $this->editando_id = $notatipotramite->id;
        $this->tipotramite_id = $notatipotramite->tipotramite_id;
        $this->contenido = $notatipotramite->contenido;
    }

    public function eliminar(Notatipotramite $notatipotramite)
    {
        $notatipotramite->delete();
        session()->flash('mensaje', 'Nota del Tipo de tramite eliminado');
    }

    public function cancelarEdicion()
    {
        $this->reset(['editando_id', 'contenido']);
    }

    public function render()
    {
        return view('livewire.tipo-tramite.detalles', [
            'notatipotramites' => $this->tipotramite->notatipotramites,
        ]);
    }
}
