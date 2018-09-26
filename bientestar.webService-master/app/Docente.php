<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $table = 'docente';

    protected $fillable = [
        'usuario_id',
        'estado',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class)->with('rolUsuario');
    }
}
