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
        Schema::create('terrains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('productor_id');
            $table->foreign('productor_id')->references('id')->on('productors');
            $table->string('place');
            $table->decimal('hr_total');
            $table->decimal('hr_prod');
            $table->decimal('latitud')->nullable();
            $table->decimal('longitud')->nullable();
            $table->decimal('altitud')->nullable();
            $table->decimal('zona')->nullable();
            $table->decimal('este')->nullable();
            $table->decimal('norte')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terrains');
    }
};
