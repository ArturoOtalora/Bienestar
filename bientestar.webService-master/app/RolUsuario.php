<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolUsuario extends Model
{
    protected $table = 'rol_usuario';

    protected $fillable = [
        'rol_id',
        'usuario_id',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

}
