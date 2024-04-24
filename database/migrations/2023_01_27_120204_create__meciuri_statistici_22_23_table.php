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
        Schema::create('MeciuriStatistici_22_23', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meciID');
            $table->foreign('meciID')->references('id')->on('Meciuri_22_23');
            $table->integer('suturiEG');
            $table->integer('suturiEO');
            $table->integer('suturiPePoartaEG');
            $table->integer('suturiPePoartaEO');
            $table->integer('posesieEG');
            $table->integer('posesieEO');
            $table->integer('cartonaseGalbeneEG');
            $table->integer('cartonaseGalbeneEO');
            $table->integer('cartonaseRosiiEG');
            $table->integer('cartonaseRosiiEO');
            $table->integer('totalPaseEG');
            $table->integer('totalPaseEO');
            $table->integer('faulturiEG');
            $table->integer('faulturiEO');
            $table->integer('deposedariEG');
            $table->integer('deposedariEO');
            $table->integer('cornereEG');
            $table->integer('cornereEO');
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
        Schema::dropIfExists('MeciuriStatistici_22_23');
    }
};
