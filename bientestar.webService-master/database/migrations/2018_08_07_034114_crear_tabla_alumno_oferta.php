<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaAlumnoOferta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumno_oferta', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('alumno_id');
            $table->foreign('alumno_id')->references('id')->on('alumno');

            $table->unsignedInteger('oferta_id');
            $table->foreign('oferta_id')->references('id')->on('oferta');

            $table->unique(['oferta_id', 'alumno_id']);
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
        Schema::dropIfExists('alumno_oferta');
    }
}
