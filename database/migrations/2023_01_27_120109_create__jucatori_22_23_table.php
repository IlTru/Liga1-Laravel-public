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
        Schema::create('Jucatori_22_23', function (Blueprint $table) {
            $table->id();
            $table->string('numeJucator', 100);
            $table->unsignedBigInteger('echipaID');
            $table->foreign('echipaID')->references('id')->on('Echipe_22_23');
            $table->integer('numar');
            $table->integer('varsta');
            $table->string('pozitie', 30);
            $table->integer('inaltime');
            $table->integer('greutate');
            $table->string('nationalitate', 50);
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
        Schema::dropIfExists('Jucatori_22_23');
    }
};
