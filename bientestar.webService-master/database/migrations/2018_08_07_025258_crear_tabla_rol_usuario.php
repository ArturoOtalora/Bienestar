<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaRolUsuario extends Migration
{
    public function up()
    {
        Schema::create('rol_usuario', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuario');

            $table->unsignedInteger('rol_id');
            $table->foreign('rol_id')->references('id')->on('rol');

            $table->unique(['usuario_id', 'rol_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rol_usuario');
    }
}
