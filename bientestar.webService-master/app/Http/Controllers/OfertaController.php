<?php

namespace App\Http\Controllers;

use App\AlumnoOferta;
use App\Oferta;
use App\Alumno;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class OfertaController extends Controller
{
    public function index()
    {
        $data = DB::table('oferta')
            ->join('empresa', 'oferta.empresa_id', '=', 'empresa.id')
            ->select('oferta.*', 'empresa.nombre as empresa_nombre')
            ->where('oferta.fecha_fin', '>=', Carbon::today()->toDateString())
            ->get();

        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }

    public function find($id)
    {

        $data = DB::table('oferta')
            ->join('alumno_oferta', 'oferta.id', '=', 'alumno_oferta.oferta_id')
            ->join('empresa', 'oferta.empresa_id', '=', 'empresa.id')
            ->join('alumno', 'alumno.id', '=', 'alumno_oferta.alumno_id')
            ->join('usuario', 'usuario.id', '=', 'alumno.usuario_id')
            ->select('oferta.*', 'empresa.nombre as empresa_nombre')
            ->where('usuario.id', '=', $id)
            ->get();

        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }

    public function aplicada()
    {

        $data = DB::table('oferta')
            ->join('alumno_oferta', 'oferta.id', '=', 'alumno_oferta.oferta_id')
            ->join('empresa', 'oferta.empresa_id', '=', 'empresa.id')
            ->join('alumno', 'alumno_oferta.alumno_id', '=', 'alumno.id')
            ->join('usuario', 'alumno.usuario_id', '=', 'usuario.id')
            ->select('oferta.*', 'empresa.nombre as empresa_nombre', 'usuario.*','alumno.file_curriculum')
            ->where('oferta.fecha_fin', '>=', Carbon::today()->toDateString())
            ->get();

        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }

    public function create(Request $request)
    {

        try {

            $currentTime=Carbon::now();
            $currentTime->hour = 0;
            $currentTime->minute = 0;
            $currentTime->second = 0;
            $fecha_fin=new Carbon($request->json('fecha_fin'));
            $fechainvalida=$fecha_fin->lt($currentTime);

            if(($fechainvalida) || ($request->json('vacantes')<1) ){

                return response()->json([
                    'estado' => false,
                    'mensaje' => 'Información invalida'
                ]);
            }
            else{

            $data = new Oferta();
            $data->titulo = $request->json('titulo');
            $data->detalle = $request->json('detalle');
            $data->vacantes = $request->json('vacantes');
            $data->contacto = $request->json('contacto');
            $data->tipo_oferta = $request->json('tipo_oferta');
            $data->empresa_id = $request->json('empresa_id');
            $data->fecha_fin = $request->json('fecha_fin');
            $data->estado = 1;
            $data->save();

            return response()->json([
                'data' => $data,
                'estado' => true,
            ], 200);
        }

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error insertando la oferta',
                'detalles' => $ex,
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $currentTime=Carbon::now();
            $currentTime->hour = 0;
            $currentTime->minute = 0;
            $currentTime->second = 0;
            $fecha_fin=new Carbon($request->json('fecha_fin'));
            $fechainvalida=$fecha_fin->lt($currentTime);


            if(($fechainvalida) || ($request->json('vacantes')<1) ){

                return response()->json([
                    'estado' => false,
                    'mensaje' => 'Información invalida'
                ]);
            }
            else{
            $data = Oferta::find($id);
            $data->titulo = $request->json('titulo');
            $data->detalle = $request->json('detalle');
            $data->vacantes = $request->json('vacantes');
            $data->contacto = $request->json('contacto');
            $data->tipo_oferta = $request->json('tipo_oferta');
            $data->empresa_id = $request->json('empresa_id');
            $data->fecha_fin = $request->json('fecha_fin');
            $data->estado = $request->json('estado');
            $data->save();

            return response()->json([   
                'data' => $data,
                'estado' => true,
            ], 200);
        }
        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error editando la oferta',
                'detalles' => $ex,
            ]);
        }
    }

    public function aplica(Request $request, $id)
    {
        try {

            $data = new AlumnoOferta();

            $alumno = Alumno::where('usuario_id', '=', $request->json('id'))->first();

            $data->oferta_id = $id;
            $data->alumno_id = $alumno->id;
            $data->save();

            $mail = AlumnoOferta::find($data->id)->with('alumno', 'oferta')->first();

            $array = [
                'titulo_oferta' => $mail->oferta->titulo,
                'detalle_oferta' => $mail->oferta->detalle,
                'vacantes' => $mail->oferta->vacantes,
                'empresa' => $mail->oferta->empresa->nombre,
                'contacto' => $mail->oferta->contacto,
                'alumno' => $mail->alumno->usuario->nombre,
                'alumno_correo' => $mail->alumno->usuario->correo,
            ];
    
            config([
                'mail.to2' => $mail->alumno->usuario->correo
            ]);

            Mail::send('oferta', $array, function ($msj) {
                $msj->subject('Oferta de empleo aplicada');
                $msj->to(config('mail.to'));
                $msj->to(config('mail.to2'));
            });

            return response()->json([
                'data' => $data,
                'estado' => true,
            ], 200);

        } catch (Exception $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error aplicando a la oferta',
                'detalles' => $ex,
            ]);
        }
    }
}
