<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notaciudadano extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ciudadano_id',
        'cuerpo'
    ];

    public function ciudadano(){
        return $this->belongsTo(Ciudadano::class);
    }
}
