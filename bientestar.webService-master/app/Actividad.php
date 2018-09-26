<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividad';

    public function tipoActividad()
    {
        return $this->belongsTo(TipoActividad::class);
    }
}
