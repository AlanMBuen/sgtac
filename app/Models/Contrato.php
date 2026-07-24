<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contrato extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'empleado_id',
        'periodo',
        'fecha_inicio',
        'fecha_termino',
        'estado'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_termino' => 'date'
    ];

    public function empleado(){
        return $this->belongsTo(Empleado::class);
    }
}
