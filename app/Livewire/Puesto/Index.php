<?php

namespace App\Livewire\Puesto;

use App\Models\Puesto;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public string $nombre = '';
    public string $clave = '';
    public string $descripcion = '';
    public ?int $editando_id = null;
    public string $buscar = '';

    public function updating()
    {
        $this->resetPage();
    }

    protected function rules(): array 
    {
        return [
            'nombre' => 'required|string|max:255',
            'clave' => 'required|string|max:16|unique:puestos,clave' . $this->editando_id,
            'descripcion' => 'nullable|string|max:1000'
        ];
    }

    public function crear(){
        $this->validate();

        $datos = [
            'nombre' => $this->nombre,
            'clave' => $this->clave,
            'descripcion' => $this->descripcion
        ];

        if($this->editando_id){
            Puesto::find($this->editando_id)->update($datos);
            session()->flash('mensaje','Puesto editado correctamente');
        } else {
            Puesto::create($datos);
            session()->flash('mensaje','Puesto creado correctamente');
        }
    }

    public function editar(Puesto $puesto){
        $this->editando_id = $puesto->id;
        $this->nombre = $puesto->nombre;
        $this->clave = $puesto->clave;
        $this->descripcion = $puesto->descripcion;
    }

    public function eliminar(Puesto $puesto){
        $puesto->delete();
        session()->flash('mensaje','Puesto eliminado correctamente');
    }

    public function cancelarEdicion(){
        $this->reset(['editando_id', 'nombre', 'clave', 'descripcion']);
    }

    public function render()
    {
        $query = Puesto::query();
        if(!empty($this->buscar)){
            $query->where(function($q){
                $q->where('nombre', 'LIKE', '%' . $this->buscar . '%')
                  ->orWhere('clave', 'LIKE', '%' . $this->buscar . '%');
            });
        }

        return view('livewire.puesto.index',[
            'puestos' => $query->orderBy('nombre')->latest()->paginate(10),
        ]);
    }
}
