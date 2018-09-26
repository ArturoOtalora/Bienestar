<?php

namespace App\Http\Controllers;

use App\Empleado;
use App\Persona;
use App\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmpleadoController extends Controller
{

    public function index()
    {
        $data = Empleado::All();

        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }

    public function find($id)
    {
        $data = Empleado::find($id);

        return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
    }

    public function create(Request $request)
    {

        try {

            $usuario = new Usuario();
            $empleado = new Empleado();
            $persona = new Persona();

            DB::transaction(function () use ($request, $usuario, $empleado, $persona) {
                $usuario->token = str_random(32);
                $usuario->save();

                $persona->nombre = $request->json('nombre');
                $persona->apellidos = $request->json('apellidos');
                $persona->correo = $request->json('correo');
                $persona->save();

                $empleado->documento = $request->json('documento');
                $empleado->contrasena = Hash::make($request->json('contrasena'));
                $empleado->usuario_id = $usuario->id;
                $empleado->persona_id = $persona->id;
                $empleado->save();
            });
            return response()->json([
                'data' => $empleado,
                'estado' => true,
            ], 200);

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error insertando el empleado',
                'detalles' => $ex,
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Empleado::find($id);

            $data->documento = $request->json('documento');
            $data->nombre = $request->json('nombre');
            $data->apellidos = $request->json('apellidos');
            $data->correo = $request->json('correo');
            $data->estado = $request->json('estado');
            if ($request->json('contrasena')) {
                $data->contrasena = Hash::make($request->json('contrasena'));
            }
            $data->save();

            return response()->json([
                'data' => $data,
                'estado' => true,
            ], 200);

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error editando el empleado',
                'detalles' => $ex,
            ]);
        }

    }
}
