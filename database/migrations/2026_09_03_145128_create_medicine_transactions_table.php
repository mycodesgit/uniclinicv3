<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicine_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained('medicines')->onDelete('cascade');
            $table->foreignId('batch_id')->nullable()->constrained('medicine_batches')->onDelete('set null');
            
            // Reference to patient visits if dispenses are tied to clinic visits
            $table->foreignId('patientvisit_id')->nullable()->constrained('patientvisits')->onDelete('set null');

            // Transaction Types: 'receive' (stock-in), 'dispense' (to patient), 'adjustment' (manual count fix), 'expired' (disposal)
            $table->enum('transaction_type', ['receive', 'dispense', 'adjustment', 'expired', 'return']);
            
            $table->integer('quantity'); // Positive for stock-in, negative for dispenses
            $table->string('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null'); // Staff ID
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicine_transactions');
    }
};
