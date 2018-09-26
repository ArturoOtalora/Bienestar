<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuario';

    protected $fillable = [
        'token',
        'correo',
        'documento',
        'nombre',
        'contrasena',
    ];

    public function rolUsuario()
    {
        return $this->hasMany(RolUsuario::class)->with('rol');
    }

}
