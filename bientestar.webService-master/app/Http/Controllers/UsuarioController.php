<?php

namespace App\Http\Controllers;

use App\Administrador;
use App\Alumno;
use App\Docente;
use App\Rol;
use App\RolUsuario;
use App\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{

    public function login(Request $request)
    {
        $usuario = Usuario::where('documento', '=', $request->json('documento'))->first();
        if ($usuario) {
            if (Hash::check($request->json('contrasena'), $usuario->contrasena)) {
                return response()->json([
                    'data' => Usuario::where('id', $usuario->id)->with('rolUsuario')->first(),
                    'estado' => true,
                ], 200);
            }
        }

        return response()->json([
            'estado' => false,
            'mensaje' => 'Usuario incorrecto',
        ]);
    }

    public function crearAlumno(Request $request)
    {

        try {

            $usuario = Usuario::where('documento', '=', $request->json('documento'))
                /*->orWhere('correo', '=', $request->json('correo'))*/->first();

            if ($usuario) {

                $alumno = Alumno::where('usuario_id', '=', $usuario->id)->first();
                $administrador = Administrador::where('usuario_id', '=', $usuario->id)->first();
                if ($alumno) {
                    return response()->json([
                        'estado' => false,
                        'mensaje' => 'El alumno ya existe',
                    ]);
                }
               else if ($administrador) {
                    return response()->json([
                        'estado' => false,
                        'mensaje' => 'El usuario no se puede crear, perfil no valido',
                    ]);
                }
                else {
                    $temp='existente';
                    $alumno = new Alumno();
                    $alumno->usuario_id = $usuario->id;
                    $alumno->estado = 1;
                    $alumno->save();

                    $rol = Rol::where('nombre', '=', 'Alumno')->first();
                    $usuario_rol = new RolUsuario();
                    $usuario_rol->usuario_id = $usuario->id;
                    $usuario_rol->rol_id = $rol->id;
                    $usuario_rol->save();

                    return response()->json([
                        'data' => $usuario,
                        'estado' => true,
                    ], 200);
                }

            } else {

                $usuario = new Usuario();
                DB::transaction(function () use ($request, $usuario) {
                        
                    $usuario->nombre = $request->json('nombre');
                    $usuario->documento = $request->json('documento');
                    $usuario->correo = $request->json('correo');
                    $usuario->contrasena = Hash::make($request->json('documento'));
                    $usuario->token = str_random(32);
                    $usuario->save();

                    $alumno = new Alumno();
                    $alumno->usuario_id = $usuario->id;
                    $alumno->estado = 1;
                    $alumno->save();

                    $rol = Rol::where('nombre', '=', 'Alumno')->first();
                    $usuario_rol = new RolUsuario();
                    $usuario_rol->usuario_id = $usuario->id;
                    $usuario_rol->rol_id = $rol->id;
                    $usuario_rol->save();

                });

                return response()->json([                  
                   'data' => Usuario::where('id', $usuario->id)->with('rolUsuario')->first(),
                    'estado' => true,
                ], 200);

            }

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error registrando el alumno',
                'detalles' => $ex,
            ]);
        }
    }

    public function getDocentes()
    {
        $data = DB::table('docente')
        ->join('usuario', 'usuario.id', '=', 'docente.usuario_id')       
        ->select('usuario.nombre','usuario.correo','usuario.documento','usuario.id')
        ->get();

        return response()->json([
           'data' => $data,
            'estado' => true,
        ], 200);

    }

    public function crearDocente(Request $request)
    {
        try {

            $usuario = Usuario::where('documento', '=', $request->json('documento'))
              /*  ->orWhere('correo', '=', $request->json('correo'))*/->first();

            if ($usuario) {

                $docente = Docente::where('usuario_id', '=', $usuario->id)->first();
                $administrador = Administrador::where('usuario_id', '=', $usuario->id)->first();
                if ($docente) {
                    return response()->json([
                        'estado' => false,
                        'mensaje' => 'El docente ya existe',
                    ]);
                }
                else if ($administrador) {
                    return response()->json([
                        'estado' => false,
                        'mensaje' => 'El usuario no se puede crear, perfil no valido',
                    ]);
                }
                else {
                    $docente = new Docente();
                    $docente->usuario_id = $usuario->id;
                    $docente->estado = 1;
                    $docente->save();

                    $rol = Rol::where('nombre', '=', 'Docente')->first();
                    $usuario_rol = new RolUsuario();
                    $usuario_rol->usuario_id = $usuario->id;
                    $usuario_rol->rol_id = $rol->id;
                    $usuario_rol->save();

                    return response()->json([
                        'data' => $usuario,
                        'estado' => true,
                    ], 200);
                }

            } else {

                $usuario = new Usuario();
                DB::transaction(function () use ($request, $usuario) {

                    $usuario->nombre = $request->json('nombre');
                    $usuario->documento = $request->json('documento');
                    $usuario->correo = $request->json('correo');
                    $usuario->contrasena = Hash::make($request->json('documento'));
                    $usuario->token = str_random(32);
                    $usuario->save();

                    $docente = new Docente();
                    $docente->usuario_id = $usuario->id;
                    $docente->estado = 1;
                    $docente->save();

                    $rol = Rol::where('nombre', '=', 'Docente')->first();
                    $usuario_rol = new RolUsuario();
                    $usuario_rol->usuario_id = $usuario->id;
                    $usuario_rol->rol_id = $rol->id;
                    $usuario_rol->save();

                });

                return response()->json([
                    'data' => Usuario::where('id', $usuario->id)->with('rolUsuario')->first(),
                    'estado' => true,
                ], 200);

            }

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error registrando el docente',
                'detalles' => $ex,
            ]);
        }
    }

    public function actualizarUsuario(Request $request, $id)
    {
        try {
            $data = Usuario::find($id);
            $data->correo = $request->json('correo');
            $data->save();

            return response()->json([
                'data' => $data,
                'estado' => true,
            ], 200);

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error editando el usuario',
                'detalles' => $ex,
            ]);
        }
    }

    public function actualizarAlumno(Request $request, $id){
        try{

            $data = Alumno::find($id);
            $data->file_curriculum = $request->json('file_curriculum');
            $data->save();

           return response()->json([
            'data' => $data,
            'estado' => true,
        ], 200);
        }
        catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error actualizando el alumno',
                'detalles' => $ex,
            ]);
        }
    
    }

    public function getAlumno(Request $request, $id){
        try{
           $alumno = Alumno::where('usuario_id', '=', $request->id)->first();

           return response()->json([
            'data' => $alumno,
            'estado' => true,
        ], 200);
        }
        catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error obteniendo el alumno',
                'detalles' => $ex,
            ]);
        }
    
    }

    public function getAdministradores()
    {

        $data = DB::table('administrador')
        ->join('usuario', 'usuario.id', '=', 'administrador.usuario_id')       
        ->select('usuario.nombre','usuario.correo','usuario.documento','usuario.id')
        ->get();

        return response()->json([
           'data' => $data,
            'estado' => true,
        ], 200);

    }

    public function crearAdministrador(Request $request)
    {
        try {

            $usuario = Usuario::where('documento', '=', $request->json('documento'))
              /*  ->orWhere('correo', '=', $request->json('correo'))*/->first();

            if ($usuario) {
                $alumno = Alumno::where('usuario_id', '=', $usuario->id)->first();
                $docente = Docente::where('usuario_id', '=', $usuario->id)->first();
                $administrador = Administrador::where('usuario_id', '=', $usuario->id)->first();
                if ($administrador) {
                    return response()->json([
                        'estado' => false,
                        'mensaje' => 'El administrador ya existe',
                    ]);
                }
                else if ($alumno || $docente) {
                    return response()->json([
                        'estado' => false,
                        'mensaje' => 'El usuario no se puede crear, perfil no valido',
                    ]);
                }
                else {
                    $docente = new Administrador();
                    $docente->usuario_id = $usuario->id;
                    $docente->estado = 1;
                    $docente->save();

                    $rol = Rol::where('nombre', '=', 'Administrador')->first();
                    $usuario_rol = new RolUsuario();
                    $usuario_rol->usuario_id = $usuario->id;
                    $usuario_rol->rol_id = $rol->id;
                    $usuario_rol->save();

                    return response()->json([
                        'data' => $usuario,
                        'estado' => true,
                    ], 200);
                }

            } else {

                $usuario = new Usuario();
                DB::transaction(function () use ($request, $usuario) {

                    $usuario->nombre = $request->json('nombre');
                    $usuario->documento = $request->json('documento');
                    $usuario->correo = $request->json('correo');
                    $usuario->contrasena = Hash::make($request->json('documento'));
                    $usuario->token = str_random(32);
                    $usuario->save();

                    $docente = new Administrador();
                    $docente->usuario_id = $usuario->id;
                    $docente->estado = 1;
                    $docente->save();

                    $rol = Rol::where('nombre', '=', 'Administrador')->first();
                    $usuario_rol = new RolUsuario();
                    $usuario_rol->usuario_id = $usuario->id;
                    $usuario_rol->rol_id = $rol->id;
                    $usuario_rol->save();

                });

                return response()->json([
                    'data' => Usuario::where('id', $usuario->id)->with('rolUsuario')->first(),
                    'estado' => true,
                ], 200);

            }

        } catch (QueryException $ex) {
            return response()->json([
                'estado' => false,
                'mensaje' => 'Error registrando el docente',
                'detalles' => $ex,
            ]);
        }
    }

}
