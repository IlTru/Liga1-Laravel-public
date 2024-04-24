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
        Schema::table('Schimbari_22_23', function($table) {
            $table->unsignedBigInteger('echipaID');
            $table->foreign('echipaID')->references('id')->on('Echipe_22_23');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Schimbari_22_23', function (Blueprint $table) {
            $table->dropColumn('echipaID');
        });
    }
};
