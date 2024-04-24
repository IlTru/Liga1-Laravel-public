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
        Schema::create('Meciuri_22_23', function (Blueprint $table) {
            $table->id();
            $table->string('faza', 50);
            $table->integer('nrEtapa');
            $table->boolean('disputat');
            $table->date('data');
            $table->unsignedBigInteger('echipaGazdaID');
            $table->foreign('echipaGazdaID')->references('id')->on('Echipe_22_23');
            $table->unsignedBigInteger('echipaOaspeteID');
            $table->foreign('echipaOaspeteID')->references('id')->on('Echipe_22_23');
            $table->integer('goluriEG');
            $table->integer('goluriEO');
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
        Schema::dropIfExists('Meciuri_22_23');
    }
};
