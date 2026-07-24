<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'direccion',
    ];

    protected static function booted(){
        static::deleting(function($departamento){
            $departamento->etiquetadepartamentos()->delete();
        });
    }

    public function etiquetadepartamentos()
    {
        return $this->hasMany(Etiquetadepartamento::class)->latest();
    }

    public function empleados()
    {
        return $this->hasMany(Empleado::class)->latest();
    }
}
