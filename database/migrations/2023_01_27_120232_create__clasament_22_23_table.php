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
        Schema::create('Clasament_22_23', function (Blueprint $table) {
            $table->id();
            $table->string('faza', 100);
            $table->unsignedBigInteger('echipaID');
            $table->foreign('echipaID')->references('id')->on('Echipe_22_23');
            $table->integer('pozitie');
            $table->integer('meciuriJucate');
            $table->integer('victorii');
            $table->integer('egaluri');
            $table->integer('infrangeri');
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
        Schema::dropIfExists('Clasament_22_23');
    }
};
