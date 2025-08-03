<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ProtegePorPermiso;
use App\Models\ReservaTurno;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MisTurnosController extends Controller
{
    public function __construct()
    {
        foreach (ProtegePorPermiso::middlewarePorModulo('Mis Turnos') as [$middleware, $actions]) {
            $this->middleware($middleware)->only($actions);
        }
    }

    public function index()
    {

        $permisos = ProtegePorPermiso::flagsPorModulo('Mis Turnos');

        $idUsuario = optional(Auth::user())->id;

        $turnos = ReservaTurno::with(['turnoPlantilla.actividad', 'turnoPlantilla.instructor'])
            ->where('id_usuario', $idUsuario)->orderByDesc('fecha_turno')->paginate(10);

        return view('mis_turnos.index', compact('turnos', 'permisos'));
    }

    public function destroy($id)
    {

         $idUsuario = optional(Auth::user())->id;

        $reserva = ReservaTurno::where('id', $id)
            ->where('id_usuario', $idUsuario)->get()
            ->firstOrFail();

        try {
            $reserva->cancelar(); // método en el modelo
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al cancelar: ' . $e->getMessage()]);
        }

        return back()->with('success', 'Turno cancelado correctamente.');
    }
}
