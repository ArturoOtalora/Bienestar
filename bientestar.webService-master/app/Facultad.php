<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    protected $table = 'facultad';

    protected $fillable = [
        'nombre',
    ];
}
