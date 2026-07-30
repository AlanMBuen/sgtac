<?php

namespace App\Livewire\Contrato;

use App\Models\Contrato;
use App\Models\Empleado;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public string $empleado_id = '';
    public int $periodo = 0;
    public string $estado = '';
    public string $fecha_inicio = '';
    public string $fecha_termino = '';
    public ?int $editando_id = null;
    public string $buscar = '';

    public function updating(){
        $this->resetPage();
    }

    protected function rules(): array 
    {
        return [
            'empleado_id' => 'nullable|exists:empleados,id',
            'periodo' => 'required|int|max:24',
            'estado' => 'required|in:activo,vencido,evaluando',
            'fecha_inicio'  => 'required|date|after_or_equal:today',
            'fecha_termino' => 'required|date|after:fecha_inicio',
        ];
    }

    public function crear(){
        $this->validate();

        $datos = [
            'empleado_id' => $this->empleado_id,
            'periodo' => $this->periodo,
            'estado' => $this->estado,
            'fecha_inicio'  => $this->fecha_inicio,
            'fecha_termino' => $this->fecha_termino,
        ];

        if($this->editando_id){
            Contrato::find($this->editando_id)->update($datos);
            session()->flash('mensaje','Contrato editado correctamente');
        } else {
            Contrato::create($datos);
            session()->flash('mensaje','Contrato creado correctamente');
        }
    }

    public function editar(Contrato $contrato){
        $this->editando_id = $contrato->id;
        $this->empleado_id = $contrato->empleado_id;
        $this->periodo = $contrato->periodo;
        $this->fecha_inicio = $contrato->fecha_inicio;
        $this->fecha_termino = $contrato->fecha_termino;
        $this->estado = $contrato->estado;
    }

    public function eliminar(Contrato $contrato){
        $contrato->delete();
        session()->flash('mensaje','Contrato eliminado correctamente');
    }

    public function cancelarEdicion(){
        $this->reset(['editando_id', 'empleado_id', 'periodo', 'fecha_inicio', 'fecha_termino', 'estado']);
    }

    public function render()
    {
        $query = Contrato::query();
        if(!empty($this->buscar)){
            $query->where(function($q){
                $q->where('estado', 'LIKE', '%' . $this->buscar . '%')

                ->orWhereHas('empleado', function($queryEmp) {
                    $queryEmp->where('nombre', 'LIKE', '%' . $this->buscar . '%');
                });

            });
        }

        return view('livewire.contrato.index',[
            'contratos' => $query->orderBy('nombre')->latest()->paginate(10),
            'empleados' => Empleado::orderBy('nombre')->latest()->get(),
        ]);
    }
}
