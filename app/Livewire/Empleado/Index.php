<?php

namespace App\Livewire\Empleado;

use App\Models\Departamento;
use App\Models\Empleado;
use App\Models\Puesto;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public string $departamento_id = '';
    public string $puesto_id = '';
    public string $nombre = '';
    public string $apellido_paterno = '';
    public string $apellido_materno = '';
    public string $correo = '';
    public string $telefono = '';
    public int $sueldo = 0;
    public ?int $editando_id = null;
    public string $buscar = '';

    public function updating()
    {
        $this->resetPage();
    }

    protected function rules(): array 
    {
        return [
            'departamento_id' => 'nullable|exists:departamentos,id',
            'puesto_id' => 'nullable|exists:puestos,id',
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'correo' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'sueldo' => 'required|int',
        ];
    }

    public function crear(){
        $this->validate();

        $datos = [
            'departamento_id' => $this->departamento_id,
            'puesto_id' => $this->puesto_id,
            'nombre' => $this->nombre,
            'apellido_paterno' => $this->apellido_paterno,
            'apellido_materno' => $this->apellido_materno,
            'correo' => $this->correo,
            'telefono' => $this->telefono,
            'sueldo' => $this->sueldo,
        ];

        if($this->editando_id){
            Empleado::find($this->editando_id)->update($datos);
            session()->flash('mensaje','Empleado editado correctamente');
        } else {
            Empleado::create($datos);
            session()->flash('mensaje','Empleado creado correctamente');
        }

        $this->cancelarEdicion();
    }

    public function editar(Empleado $empleado){
        $this->editando_id = $empleado->id;
        $this->departamento_id = $empleado->departamento_id;
        $this->puesto_id = $empleado->puesto_id;
        $this->nombre = $empleado->nombre;
        $this->apellido_paterno = $empleado->apellido_paterno;
        $this->apellido_materno = $empleado->apellido_materno;
        $this->correo = $empleado->correo;
        $this->telefono = $empleado->telefono;
        $this->sueldo = $empleado->sueldo;
    }

    public function eliminar(Empleado $empleado){
        $empleado->delete();
        session()->flash('mensaje','Empleado eliminado correctamente');
    }

    public function cancelarEdicion(){
        $this->reset(['editando_id', 'departamento_id', 'puesto_id', 'nombre', 'apellido_paterno', 'apellido_materno', 'correo', 'telefono', 'sueldo']);
    }

    public function render()
    {
        $query = Empleado::query();

        if(!empty($this->buscar)){
            $query->where(function ($q){
                $q->where('nombre', 'LIKE', '%' . $this->buscar . '%')
                  ->orWhere('apellido_paterno', 'LIKE', '%' . $this->buscar . '%')

                  ->orWhereHas('puesto', function($queryPuesto) {
                    $queryPuesto->where('nombre', 'LIKE', '%' . $this->buscar . '%');
                  })

                  ->orWhereHas('departamento', function($queryDep) {
                    $queryDep->where('nombre', 'LIKE', '%' . $this->buscar . '%');
                  });
            });
        }

        return view('livewire.empleado.index',[
            'empleados' => $query->orderBy('nombre')->latest()->paginate(10),
            'departamentos' => Departamento::orderBy('nombre')->latest()->get(),
            'puestos' => Puesto::orderBy('nombre')->latest()->get(),
        ]);
    }
}
