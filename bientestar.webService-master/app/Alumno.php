<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumno';

    protected $fillable = [
        'usuario_id',
        'file_curriculum',
        'estado',

    ];

    protected $hidden = [
        'contrasena',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
