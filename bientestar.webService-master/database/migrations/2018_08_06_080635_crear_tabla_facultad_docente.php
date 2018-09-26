<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaFacultadDocente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facultad_docente', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('facultad_id');
            $table->foreign('facultad_id')->references('id')->on('facultad');

            $table->unsignedInteger('docente_id');
            $table->foreign('docente_id')->references('id')->on('docente');

            $table->unique(['facultad_id', 'docente_id']);
            $table->boolean('estado')->default(1);
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
        Schema::dropIfExists('facultad_docente');
    }
}
