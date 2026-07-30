<?php

namespace App\Livewire\TipoTramite;

use App\Models\Departamento;
use App\Models\Tipotramite;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public string $departamento_id = '';
    public string $nombre = '';
    public ?string $descripcion = '';
    public ?int $duracion = null;
    public ?int $editando_id = null;
    public string $buscar = '';

    public function updating(){
        $this->resetPage();
    }

    protected function rules(): array {
        return [
            'departamento_id' => 'required|exists:departamentos,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'duracion' => 'nullable|int|max:100'
        ];
    }

    public function crear()
    {
        $this->validate();

        $datos = [
            'departamento_id' => $this->departamento_id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'duracion' => $this->duracion
        ];

        if($this->editando_id){
            Tipotramite::find($this->editando_id)->update($datos);
            session()->flash('mensaje','Tipo de tramite editado');
        } else {
            Tipotramite::create($datos);
            session()->flash('mensaje','Tipo de tramite creado');
        }

        $this->cancelarEdicion();
    }

    public function editar(Tipotramite $tipotramite)
    {
        $this->editando_id = $tipotramite->id;
        $this->departamento_id = $tipotramite->departamento_id;
        $this->nombre = $tipotramite->nombre;
        $this->descripcion = $tipotramite->descripcion;
        $this->duracion = $tipotramite->duracion;
    }

    public function eliminar(Tipotramite $tipotramite)
    {
        $tipotramite->delete();
        session()->flash('mensaje','Tipo de tramite eliminado');
    }

    public function cancelarEdicion()
    {
        $this->reset(['editando_id', 'departamento_id', 'nombre', 'descripcion', 'duracion']);
    }

    public function render()
    {
        $query = Tipotramite::query();

        if(!empty($this->buscar)){
            $query -> where(function($q){
                $q->where('nombre', 'LIKE', '%' . $this->buscar . '%')
                  ->orWhere('duracion', 'LIKE', '%' . $this->buscar . '%')

                  ->orWhereHas('departamento', function($queryDep){
                    $queryDep ->where('departamento', 'LIKE', '%' . $this->buscar . '%');
                  });
            });
        }

        return view('livewire.tipo-tramite.index',[
            'tipotramites' => Tipotramite::orderBy('nombre')->latest()->paginate(10),
            'departamentos' => Departamento::orderBy('nombre')->latest()->get(),
        ]);
    }
}
