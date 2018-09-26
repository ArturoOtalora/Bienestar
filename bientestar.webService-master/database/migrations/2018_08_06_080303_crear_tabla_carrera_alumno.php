<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaCarreraAlumno extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrera_alumno', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('carrera_id');
            $table->foreign('carrera_id')->references('id')->on('carrera');

            $table->unsignedInteger('alumno_id');
            $table->foreign('alumno_id')->references('id')->on('alumno');

            $table->unsignedInteger('jornada_id');
            $table->foreign('jornada_id')->references('id')->on('jornada');

            $table->unique(['carrera_id', 'alumno_id']);

            $table->boolean('estado')->default(1);
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
        Schema::dropIfExists('carrera_alumno');
    }
}
