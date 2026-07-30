<?php

namespace App\Livewire\Tramite;

use App\Models\Ciudadano;
use App\Models\Empleado;
use App\Models\Tipotramite;
use App\Models\Tramite;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public string $tipotramite_id = '';
    public string $ciudadano_id = '';
    public ?string $asignado_id = '';
    public string $folio = '';
    public string $estado = '';
    public string $fecha_limite = '';
    public ?int $editando_id = null;
    public string $buscar = '';

    public function upditing(){
        $this->resetPage();
    }

    protected function rules(): array {
        return [
            'tipotramite_id' => 'required|exists:tipotramites,id',
            'ciudadano_id' => 'required|exists:ciudadanos,id',
            'asignado_id' => 'nullable|exists:empleados,id',
            'folio' => 'required|string|max:255|unique:tramites,folio,' . $this->editando_id,
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
            'fecha_limite' => $this->fecha_limite,
        ];

        if($this->editando_id){
            $datos['estado'] = $this->estado;
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

        $query = Tramite::query();
        if(!empty($this->buscar)){
            $query->where(function($q){
                $q->where('folio', 'LIKE', '%' . $this->buscar . '%')
                  ->orWhere('estado', 'LIKE', '%' . $this->buscar . '%')
                
                  ->orWhereHas('empleado', function($queryEmp){
                    $queryEmp->where('nombre', 'LIKE', '%' . $this->buscar . '%');
                  })

                  ->orWhereHas('tipotramite', function($queryTip){
                    $queryTip->where('nombre', 'LIKE', '%' . $this->buscar . '%');
                  })

                  ->orWhereHas('ciudadano', function($queryCiu){
                    $queryCiu->where('nombre', 'LIKE', '%' . $this->buscar . '%');
                  });
            });
        }

        return view('livewire.tramite.index',[
            'tramites' => $query->orderBy('nombre')->latest()->paginate(10),
            'tipotramites' => Tipotramite::orderBy('nombre')->latest()->get(),
            'ciudadanos' => Ciudadano::orderBy('nombre')->latest()->get(),
            'asignados' => Empleado::orderBy('nombre')->latest()->get(),
        ]);
    }
}
