<?php

namespace App\Http\Controllers;

use App\Pasantia;
use App\Alumno;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasantiaController extends Controller
{
    public function index()
    {

        $data = DB::table('pasantia')
            ->join('alumno', 'alumno.id', '=', 'pasantia.alumno_id')
            ->join('usuario', 'usuario.id', '=', 'alumno.usuario_id')
            ->join('empresa', 'empresa.id', '=', 'pasantia.empresa_id')
            ->select('pasantia.*', 'usuario.nombre as alumno_nombre',
                'empresa.nombre as empresa_nombre')
            ->get();

        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }

    public function find($id)
    {

        $alumno = Alumno::where('usuario_id', '=', $id)->first();
        $data = Pasantia::where('alumno_id', $alumno->id)->first();

        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }

    public function create(Request $request)
    {

        try {

            $alumno = Alumno::where('usuario_id', '=', $request->json('alumno_id'))->first();

            $data = new Pasantia();
           $data->fecha_inicio = $request->json('fecha_inicio');
            $data->fecha_fin = $request->json('fecha_fin');
            $data->file_carta = $request->json('file_carta');
            $data->file_evaluacion = $request->json('file_evaluacion');
            $data->file_certificado = $request->json('file_certificado');
            $data->estado = false;
            $data->empresa_id = $request->json('empresa_id');
            $data->alumno_id = $alumno->id;
            $data->observaciones = $request->json('observaciones');
            $data->save();

            return response()->json([
                'data' => $data,
                'estado' => true
            ], 200);

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error insertando la pasantia',
                'detalles' => $ex,
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Pasantia::find($id);
            $data->fecha_inicio = $request->json('fecha_inicio');
            $data->fecha_fin = $request->json('fecha_fin');
            $data->file_carta = $request->json('file_carta');
            $data->file_evaluacion = $request->json('file_evaluacion');
            $data->file_certificado = $request->json('file_certificado');
            $data->estado = $request->json('estado');
            $data->empresa_id = $request->json('empresa_id');
            $data->alumno_id = $request->json('alumno_id');
            $data->observaciones = $request->json('observaciones');
            $data->save();

            return response()->json([
                'data' => $data,
                'estado' => true,
            ], 200);

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error editando la pasantia',
                'detalles' => $ex,
            ]);
        }
    }
}
