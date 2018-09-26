<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaUsuario extends Migration
{

    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('correo');
            $table->string('documento');
            $table->string('contrasena');

            $table->unique(['correo', 'documento']);
            $table->string('token', 32)->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuario');
    }
}
