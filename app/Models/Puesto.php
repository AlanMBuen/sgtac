<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Puesto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'clave',
        'descripcion'
    ];

    public static function booted(){
        static::deleting(function($puesto){
            $puesto->responsabilidadespuestos()->delete();
        });
    }

    public function responsabilidadespuestos(){
        return $this->hasMany(Responsabilidadespuesto::class)->latest();
    }

    public function empleados(){
        return $this->hasMany(Empleado::class)->latest();
    }
}
