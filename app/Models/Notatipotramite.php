<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notatipotramite extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tipotramite_id',
        'contenido'
    ];

    public function tipotramite()
    {
        return $this->belongsTo(Tipotramite::class);
    }
}
