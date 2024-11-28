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
        Schema::create('molds', function (Blueprint $table) {
            $table->id();
            $table->string('code_mold')->unique(); // Código único para cada board
            $table->string('name_mold'); // Ubicación del board
            $table->decimal('width', 8, 2); // Ancho del board
            $table->decimal('height', 8, 2); // Altura del board
            $table->tinyInteger('status')->default(1);
            $table->timestamps(); // `created_at` y `updated_at`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('molds');
    }
};
