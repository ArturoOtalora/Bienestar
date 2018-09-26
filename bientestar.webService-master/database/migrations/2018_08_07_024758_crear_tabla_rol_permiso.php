<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaRolPermiso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rol_permiso', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('permiso_id');
            $table->foreign('permiso_id')->references('id')->on('permiso');

            $table->unsignedInteger('rol_id');
            $table->foreign('rol_id')->references('id')->on('rol');

            $table->unique(['permiso_id', 'rol_id']);
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
        Schema::dropIfExists('rol_permiso');
    }
}
