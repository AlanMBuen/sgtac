<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tramites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipotramite_id')->constrained('tipotramites')->onDelete('restrict');
            $table->foreignId('ciudadano_id')->constrained('ciudadanos')->onDelete('restrict');
            $table->foreignId('asignado_id')->nullable()->constrained('empleados')->nullOnDelete();
            $table->string('folio')->unique();
            $table->enum('estado',['recibido','en_revision','aprobado','rechazado','entregado'])->default('recibido');
            $table->date('fecha_limite');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramites');
    }
};
