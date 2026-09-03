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
        Schema::create('medicine_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained('medicines')->onDelete('cascade');
            $table->string('lotbatch_number');              // e.g., BATCH-2026-001
            $table->integer('quantity_received');         // Original quantity received
            $table->integer('quantity_remaining');        // Current active stock in batch
            $table->string('refnoid')->nullable();  // reference where it come from (e.g., supplier invoice number/pr no)
            $table->date('expiration_date');
            $table->date('received_date')->default(now());
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
        Schema::dropIfExists('medicine_batches');
    }
};
