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
        Schema::create('productor_condicion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('productor_id')->constrained()->onDelete('cascade'); // Relación con productor
            $table->unsignedBigInteger('condicion_id');
            $table->foreign('condicion_id')->references('id')->on('condiciones');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productor_condicion');
    }
};
