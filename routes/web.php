<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ModuloPermisoRolController;
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
