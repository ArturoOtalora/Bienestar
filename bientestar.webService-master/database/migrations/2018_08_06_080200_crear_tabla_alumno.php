<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaAlumno extends Migration
{

    public function up()
    {
        Schema::create('alumno', function (Blueprint $table) {
            $table->increments('id');

            $table->string('file_curriculum')->nullable($value = true);

            $table->unsignedInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuario');

            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alumno');
    }
}
