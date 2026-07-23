<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etiquetadepartamento extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'departamento_id',
        'contenido'
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
}
