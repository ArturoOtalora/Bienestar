<?php

$router->group(['prefix' => 'usuario'], function ($router) {

    $router->get('/', 'UsuarioController@index'); //Borrar

    $router->post('/login', 'UsuarioController@login');
    $router->put('/{id}', 'UsuarioController@actualizarUsuario');

    $router->group(['prefix' => '/alumno'], function ($router) {
        $router->post('/', 'UsuarioController@crearAlumno');
        $router->get('/{id}', 'UsuarioController@getAlumno');
        $router->put('/{id}', 'UsuarioController@actualizarAlumno');
    });

    $router->group(['prefix' => '/docente'], function ($router) {
        $router->post('/', 'UsuarioController@crearDocente');
        $router->get('/', 'UsuarioController@getDocentes');
    });

    $router->group(['prefix' => '/administrador'], function ($router) {
        $router->post('/', 'UsuarioController@crearAdministrador');
        $router->get('/', 'UsuarioController@getAdministradores');
    });

});

// $router->group(['prefix' => 'empleado'], function ($router) {
//     $router->get('/', 'EmpleadoController@index');
//     $router->get('/{id}', 'EmpleadoController@find');
//     $router->post('/', 'EmpleadoController@create');
//     $router->put('/{id}', 'EmpleadoController@update');
// });

// $router->group(['prefix' => 'docente'], function ($router) {
//     $router->get('/', 'DocenteController@index');
//     $router->get('/{id}', 'DocenteController@find');
//     $router->post('/', 'DocenteController@create');
//     $router->put('/{id}', 'DocenteController@update');
// });

// $router->group(['prefix' => 'alumno'], function ($router) {
//     $router->get('/', 'AlumnoController@index');
//     $router->get('/{id}', 'AlumnoController@find');
//     $router->post('/', 'AlumnoController@create');
//     $router->put('/{id}', 'AlumnoController@update');
// });

$router->group(['prefix' => 'oferta'], function ($router) {
    $router->get('/', 'OfertaController@index');
    $router->get('/aplicada', 'OfertaController@aplicada');
    $router->get('/{id}', 'OfertaController@find');
    $router->post('/aplica/{id}', 'OfertaController@aplica');
    $router->post('/', 'OfertaController@create');
    $router->put('/{id}', 'OfertaController@update');
});

$router->group(['prefix' => 'diplomado'], function ($router) {
    $router->get('/', 'DiplomadoController@index');
    $router->get('/inscrito', 'DiplomadoController@inscrito');
    $router->get('/{id}', 'DiplomadoController@find');
    $router->post('/', 'DiplomadoController@create');
    $router->post('/inscribe/{id}', 'DiplomadoController@inscribe');
    $router->put('/{id}', 'DiplomadoController@update');

});

$router->group(['prefix' => 'empresa'], function ($router) {
    $router->get('/', 'EmpresaController@index');
    $router->get('/{id}', 'EmpresaController@find');
    $router->post('/', 'EmpresaController@create');
    $router->put('/{id}', 'EmpresaController@update');
});

$router->group(['prefix' => 'facultad'], function ($router) {
    $router->get('/', 'FacultadController@index');
    $router->get('/{id}', 'FacultadController@find');
    $router->post('/', 'FacultadController@create');
    $router->put('/{id}', 'FacultadController@update');
});

$router->group(['prefix' => 'actividad'], function ($router) {
    $router->get('/', 'ActividadController@index');
    $router->post('/', 'ActividadController@create');
    $router->put('/{id}', 'ActividadController@update');

    $router->get('/getFotos/{id}', 'ActividadController@getFotos');
    $router->post('/subirFoto', 'ActividadController@subirFoto');
    $router->post('/borrarFoto', 'ActividadController@borrarFoto');
});

$router->group(['prefix' => 'tipo_actividad'], function ($router) {
    $router->get('/', 'TipoActividadController@index');
    $router->get('/{id}', 'TipoActividadController@find');
    $router->post('/', 'TipoActividadController@create');
    $router->put('/{id}', 'TipoActividadController@update');
});

$router->group(['prefix' => 'pasantia'], function ($router) {
    $router->get('/', 'PasantiaController@index');
    $router->get('/{id}', 'PasantiaController@find');
    $router->post('/', 'PasantiaController@create');
    $router->put('/{id}', 'PasantiaController@update');
});

$router->group(['prefix' => 'carrera'], function ($router) {
    $router->get('/', 'CarreraController@index');
    $router->get('/{id}', 'CarreraController@find');
    $router->post('/', 'CarreraController@create');
    $router->put('/{id}', 'CarreraController@update');
});

$router->group(['prefix' => 'permiso'], function ($router) {
//     $router->get('/', 'PermisoController@index');
    //     $router->get('/{id}', 'PermisoController@find');
    //     $router->post('/', 'PermisoController@create');
    //     $router->put('/{id}', 'PermisoController@update');
    $router->get('/porRol/{id}', 'PermisoController@porRol');
});
