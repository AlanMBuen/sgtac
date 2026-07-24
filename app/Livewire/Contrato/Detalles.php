<?php

namespace App\Livewire\Contrato;

use App\Models\Contrato;
use Livewire\Component;

class Detalles extends Component
{
    public Contrato $contrato;

    public function mount(Contrato $contrato){
        $this->contrato = $contrato;
    }

    public function render()
    {
        return view('livewire.contrato.detalles',[]);
    }
}
