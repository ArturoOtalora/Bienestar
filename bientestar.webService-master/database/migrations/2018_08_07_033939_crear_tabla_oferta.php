<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaOferta extends Migration
{

    public function up()
    {
        Schema::create('oferta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->longText('detalle');
            $table->integer('vacantes');
            $table->string('contacto');
            $table->string('tipo_oferta');

            $table->unsignedInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresa');

            $table->boolean('estado')->default(1);
            $table->date('fecha_fin');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('oferta');
    }
}
