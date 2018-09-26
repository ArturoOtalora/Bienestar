<?php

namespace App\Http\Controllers;

use App\RolPermiso;

class PermisoController extends Controller
{
    public function porRol($id)
    {

        $data = RolPermiso::where('rol_id', $id)->with('rol', 'permiso')->get();
        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);

    }
}
