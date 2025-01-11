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
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained(); 
            $table->decimal('credit', 15, 2); 
            $table->decimal('interest_rate', 5, 2)->nullable(); 
            $table->decimal('total_amount', 15, 2)->nullable(); 
            $table->decimal('remaining_balance', 15, 2)->nullable(); 
            $table->date('loan_date'); 
            $table->date('due_date'); 
            $table->enum('status', ['active', 'paid', 'overdue'])->default('active'); 
            $table->string('currency', 3)->default('PEN'); 
            $table->text('purpose')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
};
