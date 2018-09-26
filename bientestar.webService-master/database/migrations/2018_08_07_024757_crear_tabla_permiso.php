<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaPermiso extends Migration
{
    public function up()
    {
        Schema::create('permiso', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->string('componente');

            $table->unique(['titulo', 'componente']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permiso');
    }
}
