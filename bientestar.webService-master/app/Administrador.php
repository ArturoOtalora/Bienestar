<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    protected $table = 'administrador';

    protected $fillable = [
        'usuario_id',
        'estado',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class)->with('rolUsuario');
    }

}
