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
        Schema::create('patientvisits', function (Blueprint $table) {
            $table->id();
            $table->string('stid')->nullable()->index();
            $table->string('stdntID')->nullable();
            $table->string('consultID')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->text('chief_complaint')->nullable();
            $table->string('bp')->nullable();
            $table->string('pr')->nullable();
            $table->string('rr')->nullable();
            $table->string('spo')->nullable();
            $table->string('btemp')->nullable();
            $table->string('lmp')->nullable();
            $table->string('pheight')->nullable();
            $table->string('pweight')->nullable();
            $table->string('treatment')->nullable();
            $table->string('medicine')->nullable()->default(',,,,,');
            $table->string('qty')->nullable()->default(',,,,,');
            $table->string('certificate')->nullable();
            $table->string('defaultfunction')->nullable();
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
        Schema::dropIfExists('patientvisits');
    }
};
