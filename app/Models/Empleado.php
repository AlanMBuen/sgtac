<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'departamento_id',
        'puesto_id',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'correo',
        'telefono',
        'sueldo'
    ];

    public static function booted(){
        static::deleting(function($empleado){
            $empleado->notaempleados()->delete();
            $empleado->contrato()->delete();
        });
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class);
    }

    public function notaempleados()
    {
        return $this->hasMany(Notaempleado::class)->latest();
    }

    public function contrato()
    {
        return $this->hasOne(Contrato::class);
    }

    public function tramites()
    {
        return $this->hasMany(Tramite::class)->latest();
    }
}
