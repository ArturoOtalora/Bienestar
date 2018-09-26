<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolPermiso extends Model
{
    protected $table = 'rol_permiso';

    protected $fillable = [
        'rol_id',
        'permiso_id',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

    public function permiso()
    {
        return $this->belongsTo(Permiso::class);
    }
}
