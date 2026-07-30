<?php

namespace App\Livewire\Ciudadano;

use App\Models\Ciudadano;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $nombre = '';
    public string $apellido_paterno = '';
    public string $apellido_materno = '';
    public string $curp = '';
    public string $correo = '';
    public string $telefono = '';
    public string $direccion = '';

    public ?int $editando_id = null;
    public string $buscar = '';

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    protected function rules(): array {
        return [
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'curp' => 'required|string|max:20|min:18|unique:ciudadanos,curp,' . $this->editando_id,
            'correo' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:16',
            'direccion' => 'nullable|string|max:1000',
        ];
    }

    public function crear(){
        $this->validate();

        $datos = [
            'nombre' => $this->nombre,
            'apellido_paterno' => $this->apellido_paterno,
            'apellido_materno' => $this->apellido_materno,
            'curp' => $this->curp,
            'correo' => $this->correo,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
        ];

        if($this->editando_id){
            Ciudadano::find($this->editando_id)->update($datos);
            session()->flash('mensaje','Ciudadano editado correctamente');
        } else {
            Ciudadano::create($datos);
            session()->flash('mensaje','Ciudadano creado correctamente');
        }

        $this->cancelarEdicion();
    }

    public function editar(Ciudadano $ciudadano){
        $this->editando_id = $ciudadano->id;
        $this->nombre = $ciudadano->nombre;
        $this->apellido_paterno = $ciudadano->apellido_paterno;
        $this->apellido_materno = $ciudadano->apellido_materno;
        $this->curp = $ciudadano->curp;
        $this->correo = $ciudadano->correo;
        $this->telefono = $ciudadano->telefono;
        $this->direccion = $ciudadano->direccion;
    }

    public function eliminar(Ciudadano $ciudadano){
        $ciudadano->delete();
        session()->flash('mensaje','Ciudadano eliminado correctamente');
    }

    public function cancelarEdicion(){
        $this->reset(['editando_id', 'nombre', 'apellido_paterno', 'apellido_materno', 'curp', 'correo', 'telefono', 'direccion']);
    }

    public function render()
    {
        $query = Ciudadano::query();

        if(!empty($this->buscar)){
            $query->where(function($q) {
                $q->where('nombre', 'LIKE', '%' . $this->buscar . '%')
                  ->orWhere('curp', 'LIKE', '%' . $this->buscar . '%')
                  ->orWhere('apellido_paterno', 'LIKE', '%' . $this->buscar . '%');
            });
        }

        return view('livewire.ciudadano.index',[
            'ciudadanos' => $query->orderBy('nombre')->latest()->paginate(10),
        ]);
    }
}
