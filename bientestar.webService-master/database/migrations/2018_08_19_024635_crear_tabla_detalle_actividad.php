<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaDetalleActividad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_actividad', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('imagen');

            $table->unsignedInteger('actividad_id');
            $table->foreign('actividad_id')->references('id')->on('actividad');

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
        Schema::dropIfExists('detalle_actividad');
    }
}
