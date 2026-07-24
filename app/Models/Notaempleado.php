<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notaempleado extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'empleado_id',
        'contenido'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
