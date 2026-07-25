<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentariotramite extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tramite_id',
        'empleado_id',
        'mensaje'
    ];

    public function tramite(){
        return $this->belongsTo(Tramite::class);
    }

    
    // $table->id();
    //         $table->foreignId('tramite_id')->constrained('tramites')->onDelete('cascade');
    //         $table->foreignId('empleado_id')->constrained('empleados')->onDelete('restrict');
    //         $table->text('mensaje');
    //         $table->softDeletes();
    //         $table->timestamps();

}
