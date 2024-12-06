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
        Schema::create('productor_seal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('productor_id')->constrained()->onDelete('cascade'); // Relación con productor
            $table->foreignId('seal_id')->constrained()->onDelete('cascade'); // Relación con seal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productor_seal');
    }
};
