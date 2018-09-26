<?php

namespace App\Http\Controllers;

use App\TipoActividad;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TipoActividadController extends Controller
{

    public function index()
    {
        $data = TipoActividad::All();

        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }

    public function find($id)
    {
        $data = TipoActividad::find($id);

        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }

    public function create(Request $request)
    {

        try {
            $data = new TipoActividad();
            $data->nombre = $request->json('nombre');
            $data->save();

            return response()->json([
                'data' => $data,
                'estado' => true,
            ], 200);

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error insertando el tipo de actividad',
                'detalles' => $ex,
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = TipoActividad::find($id);
            $data->nombre = $request->json('nombre');
            $data->save();

            return response()->json([
                'data' => $data,
                'estado' => true,
            ], 200);

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error editando el tipo de actividad',
                'detalles' => $ex,
            ]);
        }
    }
}
