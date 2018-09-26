<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaAlumnoDiplomado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumno_diplomado', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('alumno_id');
            $table->foreign('alumno_id')->references('id')->on('alumno');

            $table->unsignedInteger('diplomado_id');
            $table->foreign('diplomado_id')->references('id')->on('diplomado');

            $table->unique(['diplomado_id', 'alumno_id']);
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
        Schema::dropIfExists('alumno_diplomado');
    }
}
