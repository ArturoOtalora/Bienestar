<?php

use App\Administrador;
use App\Permiso;
use App\Rol;
use App\RolPermiso;
use App\RolUsuario;
use App\Usuario;
use Illuminate\Database\Seeder;

class Install extends Seeder
{

    public function run()
    {
        // Crear roles
        Rol::create(['nombre' => 'Docente']);
        Rol::create(['nombre' => 'Alumno']);
        Rol::create(['nombre' => 'Administrador']);

        // Crear permisos
        Permiso::create(['titulo' => 'Actividades', 'componente' => 'ActividadPage']);
        Permiso::create(['titulo' => 'Ofertas', 'componente' => 'OfertaPage']);
        Permiso::create(['titulo' => 'Pasantias', 'componente' => 'PasantiaPage']);
        Permiso::create(['titulo' => 'Diplomados', 'componente' => 'DiplomadoPage']);
        Permiso::create(['titulo' => 'Usuarios', 'componente' => 'UsuarioPage']);
        Permiso::create(['titulo' => 'Configuración', 'componente' => 'ConfiguracionPage']);

        //Asignar permisos a rol Administrador
        $permisos = Permiso::All();

        $rol = Rol::where('nombre', 'Administrador')->first();
        foreach ($permisos as $item) {
            RolPermiso::create(['rol_id' => $rol->id, 'permiso_id' => $item->id]);
        }

        //Crear usuario Administrador
        $admin = new Usuario();
        $admin->token = str_random(32);
        $admin->documento = 123456789;
        $admin->correo = "admin@correo.com";
        $admin->nombre = "Administrador del sistema";
        $admin->contrasena = Hash::make('123');
        $admin->save();

        $adm = new Administrador();
        $adm->usuario_id = $admin->id;
        $adm->estado = 1;
        $adm->save();

        //Asignar rol administrador al usuario administrador
        RolUsuario::create(['rol_id' => $rol->id, 'usuario_id' => $admin->id]);

        // Asignar permisos al rol Alumno
        $permisosAlumno = Permiso::whereIn('titulo', ['Actividades', 'Ofertas', 'Pasantias', 'Diplomados', 'Configuración'])->get();
        $rolAlumno = Rol::where('nombre', 'Alumno')->first();
        foreach ($permisosAlumno as $item) {
            RolPermiso::create(['rol_id' => $rolAlumno->id, 'permiso_id' => $item->id]);
        }

        // Asignar permisos al rol Docente
        $permisosDocente = Permiso::whereIn('titulo', ['Actividades'])->get();
        $rolDocente = Rol::where('nombre', 'Docente')->first();
        foreach ($permisosDocente as $item) {
            RolPermiso::create(['rol_id' => $rolDocente->id, 'permiso_id' => $item->id]);
        }
    }
}
