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
        Schema::create('notatipotramites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipotramite_id')->constrained('tipotramites')->onDelete('cascade');
            $table->text('contenido');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notatipotramites');
    }
};
