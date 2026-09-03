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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable(); // e.g., MED-001
            $table->string('name');                      // e.g., Paracetamol
            $table->string('generic_name')->nullable();  // e.g., Acetaminophen
            $table->string('dosage')->nullable();        // e.g., 500mg
            $table->string('unit')->default('pcs');      // e.g., tablet, capsule, bottle, box
            $table->integer('reorder_level')->default(10); // Minimum threshold for alert
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('medicines');
    }
};
