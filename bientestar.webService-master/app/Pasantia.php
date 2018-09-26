<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasantia extends Model
{
    protected $table = 'pasantia';

    protected $fillable = [
        'fecha_inicio',
        'fecha_fin',
        'file_carta',
        'file_evaluacion',
        'file_certificado',
        'estado',
        'empresa_id',
        'alumno_id',
        'observaciones',
    ];
}
