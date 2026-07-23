<?php

namespace App\Livewire\Departamento;

use App\Models\Departamento;
use Livewire\Component;

class Index extends Component
{
    public string $nombre = '';
    public string $descripcion = '';
    public string $direccion = '';
    public ?int $editando_id = null;

    protected function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'direccion' => 'required|string|max:1000',
        ];
    }

    public function crear()
    {
        $this->validate();

        $datos = [
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'direccion' => $this->direccion,
        ];

        if($this->editando_id){
            Departamento::find($this->editando_id)->update($datos);
            session()->flash('mensaje','Departamento actualizado correctamente');
        } else {
            Departamento::create($datos);
            session()->flash('mensaje','Departamento creado correctamente');
        }

        $this->cancelarEdicion();
    }

    public function editar(Departamento $departamento)
    {
        $this->editando_id = $departamento->id;
        $this->nombre = $departamento->nombre;
        $this->descripcion = $departamento->descripcion;
        $this->direccion = $departamento->direccion;
    }

    public function eliminar(Departamento $departamento)
    {
        $departamento->delete();
        session()->flash('mensaje','Departamento eliminado correctamente');
    }

    public function cancelarEdicion()
    {
        $this->reset(['editando_id', 'nombre', 'descripcion', 'direccion',]);
    }

    public function render()
    {
        return view('livewire.departamento.index',[
            'departamentos' => Departamento::orderBy('nombre')->latest()->get(),
        ]);
    }
}
