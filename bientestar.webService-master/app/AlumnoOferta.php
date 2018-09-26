<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlumnoOferta extends Model
{

    protected $table = 'alumno_oferta';

    protected $fillable = [
        'alumno_id',
        'oferta_id',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class)->with('usuario');
    }

    public function oferta()
    {
        return $this->belongsTo(Oferta::class)->with('empresa');
    }
}
