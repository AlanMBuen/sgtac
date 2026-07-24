<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Responsabilidadespuesto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'puesto_id',
        'responsabilidad',
        'dificultad'
    ];

    public function puesto(){
        return $this->belongsTo(Puesto::class);
    }
}
