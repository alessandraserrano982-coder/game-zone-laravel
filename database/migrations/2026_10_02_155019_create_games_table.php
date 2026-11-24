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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title');          // Título del juego
            $table->text('description');      // Descripción detallada
            $table->decimal('price', 8, 2);   // Precio
            $table->integer('stock');         // Stock
            $table->string('image')->nullable();// Imagen
            $table->timestamps();
            $table->softDeletes();            // <--- Aquí va el borrado lógico que pediste
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
