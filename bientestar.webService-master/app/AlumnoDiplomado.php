<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlumnoDiplomado extends Model
{

    protected $table = 'alumno_diplomado';

    protected $fillable = [
        'alumno_id',
        'diplomado_id',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}
