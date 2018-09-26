<?php

namespace App\Http\Controllers;

use App\Actividad;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActividadController extends Controller
{
    public function index()
    {
        $data = Actividad::with('tipoActividad')
            ->where('fecha_fin', '>=', Carbon::today()->toDateString())
            ->get();

        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }

    // public function find($id)
    // {
    //     $data = Actividad::find($id)->with('tipoActividad')->first();

    //     return response()->json([
    //         'data' => $data,
    //         'estado' => true,
    //     ], 200);
    // }

    public function create(Request $request)
    {

        try {

            $data = new Actividad();
            $data->nombre = $request->json('nombre');
            $data->detalle = $request->json('detalle');
            $data->poster = $request->json('poster');
            $data->fecha_inicio = $request->json('fecha_inicio');
            $data->fecha_fin = $request->json('fecha_fin');
            $data->tipo_actividad_id = $request->json('tipo_actividad_id');
            $data->save();

            return response()->json([
                'data' => $data,
                'estado' => true,
            ], 200);

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error insertando la actividad',
                'detalles' => $ex,
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Actividad::find($id);
            $data->nombre = $request->json('nombre');
            $data->detalle = $request->json('detalle');
            $data->poster = $request->json('poster');
            $data->fecha_inicio = $request->json('fecha_inicio');
            $data->fecha_fin = $request->json('fecha_fin');
            $data->tipo_actividad_id = $request->json('tipo_actividad_id');
            $data->save();

            return response()->json([
                'data' => $data,
                'estado' => true,
            ], 200);

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error editando la actividad',
                'detalles' => $ex,
            ]);
        }
    }

    public function inscribe(Request $request, $id)
    {
        try {
            $data = new AlumnoDiplomado();

            $data->diplomado_id = $id;
            $data->alumno_id = $request->json('id');
            $data->save();

            return response()->json([
                'data' => $data,
                'estado' => true,
            ], 200);

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error inscribiendo el diplomado',
                'detalles' => $ex,
            ]);
        }
    }

    public function subirFoto(Request $request)
    {
        $data = DB::table('detalle_actividad')->insert(
            [
                'actividad_id' => $request->json('actividad_id'),
                'imagen' => $request->json('imagen'),
            ]
        );

        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }

    public function borrarFoto($id)
    {
        $data = DB::table('detalle_actividad')->where('id', '=', $request->json('id'))->delete();
        return $data;
    }

    public function getFotos($id)
    {
        $data = DB::table('detalle_actividad')->where('actividad_id', '=', $id)->get();

        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }
}
