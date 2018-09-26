<?php

namespace App\Http\Controllers;

use App\Facultad;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class FacultadController extends Controller
{

    public function index()
    {
        $data = Facultad::All();

        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }

    public function find($id)
    {
        $data = Facultad::find($id);

        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }

    public function create(Request $request)
    {

        try {
            $data = new Facultad();
            $data->nombre = $request->json('nombre');
            $data->save();

            return response()->json([
                'data' => $data,
                'estado' => true,
            ], 200);

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error insertando la facultad',
                'detalles' => $ex,
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Facultad::find($id);
            $data->nombre = $request->json('nombre');
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
