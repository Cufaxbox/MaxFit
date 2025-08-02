<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ModuloPermisoRolController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\TurnoPlantillaController;
use App\Http\Controllers\ReservaTurnoController;
use App\Http\Controllers\MisTurnosController;
use Illuminate\Support\Facades\Route;


Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

/// aca vamos a ir agregando las nuevas rutas
Route::resource('permisos', PermisoController::class);

Route::resource('modulos', ModuloController::class);

Route::resource('actividades', ActividadController::class)->parameters([
    'actividades' => 'actividad', // Le estamos diciendo que el nombre de la variable es "actividad"
]);

Route::resource('turno_plantillas', TurnoPlantillaController::class);
Route::resource('mis_turnos', MisTurnosController::class);

Route::resource('reservar_turno', ReservaTurnoController::class);
Route::post('/reservar/{id}/{semana}', [ReservaTurnoController::class, 'reservar'])->name('reservar_turno.reservar');
Route::post('/cancelar/{id}/{semana}', [ReservaTurnoController::class, 'cancelar'])->name('reservar_turno.cancelar');

//Route::post('reservar_turno/{id}/reservar', [ReservaTurnoController::class, 'reservar'])->name('reservar_turno.reservar');
//Route::post('reservar_turno/{id}/cancelar', [ReservaTurnoController::class, 'cancelar'])->name('reservar_turno.cancelar');


//Route::post('/gestionar-turno', [ReservaTurnoController::class, 'gestionar'])->name('gestionar.turno'); //USUAMSO POST YA QUE NO GENERAMOS UN IDEX UN CREATE O UN EDIT

// VER CON LOS CHICOS MIDDLEWARE EN FUNCIONAMIENTO EJEMPLO CON USUARIOS
Route::middleware(['auth'])->group(function () {
    Route::get('usuarios', [UsuariosController::class, 'index'])
        ->middleware('verificar.permiso:Usuarios,Lectura')
        ->name('usuarios.index');

    Route::get('usuarios/create', [UsuariosController::class, 'create'])
        ->middleware('verificar.permiso:Usuarios,Alta')
        ->name('usuarios.create');

    Route::post('usuarios', [UsuariosController::class, 'store'])
        ->middleware('verificar.permiso:Usuarios,Alta')
        ->name('usuarios.store');

    Route::get('usuarios/{usuario}/edit', [UsuariosController::class, 'edit'])
        ->middleware('verificar.permiso:Usuarios,Modificacion')
        ->name('usuarios.edit');

    Route::put('usuarios/{usuario}', [UsuariosController::class, 'update'])
        ->middleware('verificar.permiso:Usuarios,Modificacion')
        ->name('usuarios.update');

    Route::delete('usuarios/{usuario}', [UsuariosController::class, 'destroy'])
        ->middleware('verificar.permiso:Usuarios,Baja')
        ->name('usuarios.destroy');
});

// RUTA PERSONALIZADA PARA CUANDO NO TENER PERMISOS (hay que hacerla)
// Route::view('/sin-permiso', 'errors.sin_permiso')->name('sin.permiso');


Route::resource('modulo-permiso-rol', ModuloPermisoRolController::class);

Route::resource('roles', RolesController::class);

Route::get('/roles/create', function () {
    return view('roles.create_role');
})->name('roles.create_role');

Route::get('/roles/edit/{rol}', [RolesController::class, 'edit'])->name('roles.edit_role');
//Route::get('/roles/create', [App\Http\Controllers\RolesController::class, 'create'])->name('roles.create');






//Route::resource('roles', RoleController::class);


//Route::get('/permisos', [PermisoController::class, 'index'])->name('permisos.index');

//Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
//Route::get('/Usuarios', [TurnoController::class, 'index'])->name('Usuarios.index');
//Route::get('/Turnos', [TurnoController::class, 'index'])->name('turnos.index');
//Route::get('/Instructores', [ActividadController::class, 'index'])->name('Intructores.index');
//Route::get('/Actividades', [ActividadController::class, 'index'])->name('Actividades.index');
//Route::get('/AdminActividades', [AdminActividadesController::class, 'index'])->name('AdminActividades.index');
//Route::get('/AdminTurnos', [AdminActividadesController::class, 'index'])->name('AdminTurnos.index');

require __DIR__ . '/auth.php';
