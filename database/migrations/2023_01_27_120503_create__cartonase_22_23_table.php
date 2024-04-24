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
        Schema::create('Cartonase_22_23', function (Blueprint $table) {
            $table->id();
            $table->boolean('culoareCartonas');
            $table->unsignedBigInteger('meciID');
            $table->foreign('meciID')->references('id')->on('Meciuri_22_23');
            $table->unsignedBigInteger('jucatorID');
            $table->foreign('jucatorID')->references('id')->on('Jucatori_22_23');
            $table->unsignedBigInteger('echipaID');
            $table->foreign('echipaID')->references('id')->on('Echipe_22_23');
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
        Schema::dropIfExists('Cartonase_22_23');
    }
};
