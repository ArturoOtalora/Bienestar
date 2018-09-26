<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{

    protected $table = 'oferta';

    protected $fillable = [
        'titulo',
        'detalle',
        'vacantes',
        'contacto',
        'tipo_oferta',
        'empresa_id',
        'estado',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function alumnoOferta()
    {
        return $this->hasMany(AlumnoOferta::class);
    }
}
