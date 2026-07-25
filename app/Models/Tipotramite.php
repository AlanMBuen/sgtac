<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipotramite extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'departamento_id',
        'nombre',
        'descripcion',
        'duracion'
    ];

    public static function booted(){
        static::deleting(function($tipotramite){
            $tipotramite->Notatipotramites()->delete();
        });
    }

    public function departamento(){
        return $this->belongsTo(Departamento::class);
    }

    public function notatipotramites(){
        return $this->hasMany(Notatipotramite::class)->latest();
    }
}
