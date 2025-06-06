<?php
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ModuloController;
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

//Route::resource('roles', RoleController::class);


//Route::get('/permisos', [PermisoController::class, 'index'])->name('permisos.index');

//Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
//Route::get('/Usuarios', [TurnoController::class, 'index'])->name('Usuarios.index');
//Route::get('/Turnos', [TurnoController::class, 'index'])->name('turnos.index');
//Route::get('/Instructores', [ActividadController::class, 'index'])->name('Intructores.index');
//Route::get('/Actividades', [ActividadController::class, 'index'])->name('Actividades.index');
//Route::get('/AdminActividades', [AdminActividadesController::class, 'index'])->name('AdminActividades.index');
//Route::get('/AdminTurnos', [AdminActividadesController::class, 'index'])->name('AdminTurnos.index');

require __DIR__.'/auth.php';
