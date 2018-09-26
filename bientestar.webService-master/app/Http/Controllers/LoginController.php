<?php
namespace App\Http\Controllers;

use App\Alumno;
use App\Docente;
use App\Empleado;
use App\Persona;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function login(Request $request)
    {

        switch ($request->rol_id) {
            case 1:
                return self::loginEmpleado($request);
                break;
            case 2:
                return self::loginDocente($request);
                break;
            case 3:
                return self::loginAlumno($request);
                break;
        }
    }

    private function loginEmpleado($request)
    {
        $empleado = Empleado::where('documento', '=', $request->json('documento'))->first();
        if ($empleado) {
            if (Hash::check($request->json('contrasena'), $empleado->contrasena)) {
                $usuario = Usuario::where('id', '=', $empleado->usuario_id)->first();
                $persona = Persona::where('id', $empleado->persona_id)->first();
                return response()->json([
                    'data' => [
                        'nombre' => "$persona->nombre",
                        'perfil' => "empleado",
                        'token' => $usuario->token,
                        'id' => $empleado->id,
                        'usuario_id' => $usuario->id,
                    ],
                    'estado' => true,
                ], 200);
            }
        }
        return response()->json([
            'estado' => false,
            'mensaje' => 'Usuario incorrecto',
        ]);
    }

    private function loginDocente($request)
    {
        $docente = Docente::where('documento', '=', $request->json('documento'))->first();

        if ($docente) {
            if (Hash::check($request->json('contrasena'), $docente->contrasena)) {
                $usuario = Usuario::where('id', '=', $docente->usuario_id)->first();
                $persona = Persona::where('id', $docente->persona_id)->first();
                return response()->json([
                    'data' => [
                        'nombre' => "$persona->nombre",
                        'perfil' => "docente",
                        'token' => $usuario->token,
                        'id' => $docente->id,
                        'usuario_id' => $usuario->id,
                    ],
                    'estado' => true,
                ], 200);
            }
        }
        return response()->json([
            'estado' => false,
            'mensaje' => 'Usuario incorrecto',
        ]);
    }

    private function loginAlumno($request)
    {
        $alumno = Alumno::where('documento', '=', $request->json('documento'))->first();
        if ($alumno) {
            if (Hash::check($request->json('contrasena'), $alumno->contrasena)) {
                $usuario = Usuario::where('id', '=', $alumno->usuario_id)->first();
                $persona = Persona::where('id', $alumno->persona_id)->first();
                return response()->json([
                    'data' => [
                        'nombre' => "$persona->nombre",
                        'perfil' => "alumno",
                        'token' => $usuario->token,
                        'id' => $alumno->id,
                        'usuario_id' => $usuario->id,
                    ],
                    'estado' => true,
                ], 200);
            }
        }
        return response()->json([
            'estado' => false,
            'mensaje' => 'Usuario incorrecto',
        ]);
    }
}
