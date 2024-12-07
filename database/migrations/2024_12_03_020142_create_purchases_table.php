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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('productor_id')->constrained(); // Relación con el productor
            $table->decimal('gross_weight', 10, 2); // Peso bruto inicial (en kg)
            $table->decimal('humidity', 5, 2);      // H% (porcentaje de humedad)
            $table->decimal('impurities', 5, 2);    // I% (porcentaje de impurezas)
            $table->decimal('net_weight', 10, 2);   // Peso neto calculado (en kg)
            $table->decimal('unit_price', 8, 2);    // Precio unitario (en soles)
            $table->decimal('total_price', 12, 2);  // Total a pagar (en soles)
            $table->decimal('recovery', 12, 2)->nullable(); // Recupero o anticipo
            $table->decimal('credit')->nullable();   // Si es crédito o contado
            $table->decimal('cash')->nullable();   // Si es al contado
            $table->string('document_credit')->nullable();  // Documento de crédito (opcional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
