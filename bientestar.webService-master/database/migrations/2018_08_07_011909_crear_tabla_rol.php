<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaRol extends Migration
{
    public function up()
    {
        Schema::create('rol', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rol');
    }
}
