<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ciudadano extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'curp',
        'correo',
        'telefono',
        'direccion',
    ];

    public static function booted()
    {
        static::deleting(function($ciudadano){
            $ciudadano->notaciudadanos()->delete();
        });
    }

    public function notaciudadanos()
    {
        return $this->hasMany(Notaciudadano::class)->latest();
    }

    public function tramites(){
        return $this->hasMany(Tramite::class)->latest();
    }
}
