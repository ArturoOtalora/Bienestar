<?php

namespace App\Http\Controllers;

use App\Carrera;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CarreraController extends Controller
{

    public function index()
    {
        $data = Carrera::with('facultad')->get();

        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }

    public function find($id)
    {
        $data = Carrera::with('facultad')->find($id)->first();

        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }

    public function create(Request $request)
    {

        try {
            $data = new Carrera();
            $data->nombre = $request->json('nombre');
            $data->facultad_id = $request->json('facultad_id');
            $data->save();

            return response()->json([
                'data' => $data,
                'estado' => true,
            ], 200);

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error insertando la carrera',
                'detalles' => $ex,
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Carrera::find($id);
            $data->nombre = $request->json('nombre');
            $data->facultad_id = $request->json('facultad_id');
            $data->save();

            return response()->json([
                'data' => $data,
                'estado' => true,
            ], 200);

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error editando la facultad',
                'detalles' => $ex,
            ]);
        }
    }
}
