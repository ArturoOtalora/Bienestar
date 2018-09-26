<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = 'carrera';

    protected $fillable = [

        'nombre',
        'facultad_id',

    ];

    public function facultad()
    {
        return $this->belongsTo(Facultad::class);
    }
}
