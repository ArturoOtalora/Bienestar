<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaActividad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividad', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('detalle');
            $table->longText('poster');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            $table->unsignedInteger('tipo_actividad_id');
            $table->foreign('tipo_actividad_id')->references('id')->on('tipo_actividad');

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
        Schema::dropIfExists('actividad');
    }
}
