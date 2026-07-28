<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tramite extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'tipotramite_id',
        'ciudadano_id',
        'asignado_id',
        'folio',
        'estado',
        'fecha_limite',
    ];

    protected $casts = [
        'fecha_limite' => 'date'
    ];

    public function tipotramite(){
        return $this->belongsTo(Tipotramite::class);
    }

    public function ciudadano(){
        return $this->belongsTo(Ciudadano::class);
    }

    public function asignado(){
        return $this->belongsTo(Empleado::class);
    }

    public function comentariotramites()
    {
        return $this->hasMany(Comentariotramite::class)->latest();
    }



}
