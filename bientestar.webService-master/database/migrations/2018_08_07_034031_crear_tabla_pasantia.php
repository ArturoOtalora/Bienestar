<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaPasantia extends Migration
{

    public function up()
    {
        Schema::create('pasantia', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->longText('file_carta')->required(false);
            $table->longText('file_evaluacion')->required(false);
            $table->longText('file_certificado')->required(false);
            $table->boolean('estado')->default(1);
            $table->longText('observaciones')->nullable(true);

            $table->unsignedInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresa');

            $table->unsignedInteger('alumno_id');
            $table->foreign('alumno_id')->references('id')->on('alumno');

            $table->unique(['empresa_id', 'alumno_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pasantia');
    }
}
