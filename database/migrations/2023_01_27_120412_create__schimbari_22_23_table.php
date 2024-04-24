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
        Schema::create('Schimbari_22_23', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meciID');
            $table->foreign('meciID')->references('id')->on('Meciuri_22_23');
            $table->unsignedBigInteger('jucatorSchimbatID');
            $table->foreign('jucatorSchimbatID')->references('id')->on('Jucatori_22_23');
            $table->unsignedBigInteger('jucatorIntratID');
            $table->foreign('jucatorIntratID')->references('id')->on('Jucatori_22_23');
            $table->integer('minut');
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
        Schema::dropIfExists('Schimbari_22_23');
    }
};
