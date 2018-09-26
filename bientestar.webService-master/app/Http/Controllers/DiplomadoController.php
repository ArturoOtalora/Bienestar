<?php

namespace App\Http\Controllers;

use App\AlumnoDiplomado;
use App\Alumno;
use App\Diplomado;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiplomadoController extends Controller
{
    public function index()
    {
        $data = DB::table('diplomado')
            ->join('facultad', 'diplomado.facultad_id', '=', 'facultad.id')
            ->select('diplomado.*', 'facultad.nombre as facultad_nombre')
            ->where('diplomado.fecha_fin', '>=', Carbon::today()->toDateString())
            ->get();

        if ($data) {
            foreach ($data as $item) {
                $item->alumnos_inscritos = DB::table('alumno_diplomado')
                    ->join('diplomado', 'diplomado.id', 'alumno_diplomado.diplomado_id')
                    ->where('alumno_diplomado.diplomado_id', '=', $item->id)
                    ->count();
            }
        }
        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }

    public function find($id)
    {
        $data = DB::table('diplomado')
            ->join('alumno_diplomado', 'diplomado.id', '=', 'alumno_diplomado.diplomado_id')
            ->join('facultad', 'diplomado.facultad_id', '=', 'facultad.id')
            ->select('diplomado.*', 'facultad.nombre as facultad_nombre')
            ->where('alumno_diplomado.alumno_id', '=', $id)
            ->get();

        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }

    public function inscrito()
    {

        $data = DB::table('diplomado')
            ->join('alumno_diplomado', 'diplomado.id', '=', 'alumno_diplomado.diplomado_id')
            ->join('facultad', 'diplomado.facultad_id', '=', 'facultad.id')
            ->join('alumno', 'alumno_diplomado.alumno_id', '=', 'alumno.id')
            ->join('usuario', 'alumno.usuario_id', '=', 'usuario.id')
            ->select('diplomado.*', 'facultad.nombre as facultad_nombre')
            ->where('diplomado.fecha_fin', '>=', Carbon::today()->toDateString())
            ->get();

        if ($data) {
            foreach ($data as $item) {
                $item->alumnos = DB::table('alumno_diplomado')
                    ->join('diplomado', 'diplomado.id', 'alumno_diplomado.diplomado_id')
                    ->join('alumno', 'alumno_diplomado.alumno_id', '=', 'alumno.id')
                    ->join('usuario', 'alumno.usuario_id', '=', 'usuario.id')
                    ->where('diplomado.fecha_fin', '>=', Carbon::today()->toDateString())
                    ->where('alumno_diplomado.diplomado_id', '=', $item->id)

                    ->select('usuario.nombre', 'usuario.correo','usuario.id', 'alumno.*')
                    ->get();
            }
        }

        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }

    public function create(Request $request)
    {

        try {

            $data = new Diplomado();
            $data->nombre = $request->json('nombre');
            $data->fecha_inicio = $request->json('fecha_inicio');
            $data->fecha_fin = $request->json('fecha_fin');
            $data->facultad_id = $request->json('facultad_id');
            $data->vacantes = $request->json('vacantes');
            $data->estado = 1;
            $data->save();

            return response()->json([
                'data' => $data,
                'estado' => true,
            ], 200);

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error insertando el diplomado',
                'detalles' => $ex,
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Diplomado::find($id);
            $data->nombre = $request->json('nombre');
            $data->fecha_inicio = $request->json('fecha_inicio');
            $data->fecha_fin = $request->json('fecha_fin');
            $data->facultad_id = $request->json('facultad_id');
            $data->vacantes = $request->json('vacantes');
            $data->estado = $request->json('estado');
            $data->save();

            return response()->json([
                'data' => $data,
                'estado' => true,
            ], 200);

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error editando el diplomado',
                'detalles' => $ex,
            ]);
        }
    }

    public function inscribe(Request $request, $id)
    {
        try {

            $alumno = Alumno::where('usuario_id', '=', $request->json('id'))->first();

            $data = new AlumnoDiplomado();

            $data->diplomado_id = $id;
            $data->alumno_id = $alumno->id;
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
}
