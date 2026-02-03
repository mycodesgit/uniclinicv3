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
        Schema::create('patientreferral', function (Blueprint $table) {
            $table->id();
            $table->string('stid')->nullable();
            $table->string('stdntID')->nullable();
            $table->string('referralID')->nullable();
            $table->date('date')->nullable();
            $table->string('time')->nullable();
            $table->string('bp')->nullable();
            $table->string('pr')->nullable();
            $table->string('rr')->nullable();
            $table->string('spo')->nullable();
            $table->string('btemp')->nullable();
            $table->string('lmp')->nullable();
            $table->string('pheight')->nullable();
            $table->string('pweight')->nullable();
            $table->string('preferfrom')->nullable();
            $table->string('preferto')->nullable();
            $table->text('reasonrefer')->nullable();
            $table->text('tentdiagnose')->nullable();
            $table->text('treatmentmedgiven')->nullable();
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
        Schema::dropIfExists('patientreferral');
    }
};
