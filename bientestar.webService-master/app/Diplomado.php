<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diplomado extends Model
{
    protected $table = 'diplomado';

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'facultad_id',
        'vacantes',
        'estado',
    ];

    public function facultad()
    {
        return $this->belongsTo(Facultad::class);
    }

    public function alumnoDiplomado()
    {
        return $this->hasMany(AlumnoDiplomado::class);
    }
}
