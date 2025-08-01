<?php

namespace App\Http\Controllers;

use App\Models\ReservaTurno;
use App\Models\TurnoPlantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Actividad;

class ReservaTurnoController extends Controller
{
public function index(Request $request)
{
    $usuarioId = Auth::id();
    $semana = $request->input('semana');
    $actividadId = $request->input('actividad'); // filtro por actividad

    // Calcular inicio y fin de semana
    if ($semana && preg_match('/^(\d{4})-W(\d{2})$/', $semana, $matches)) {
        $inicioSemana = Carbon::now()->setISODate($matches[1], $matches[2])->startOfWeek(Carbon::MONDAY);
        $finSemana = $inicioSemana->copy()->endOfWeek(Carbon::SUNDAY);
    } else {
        $inicioSemana = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $finSemana = Carbon::now()->endOfWeek(Carbon::SUNDAY);
        $semana = $inicioSemana->format('o-\WW');
    }

    // Cargar actividades para el combo
    $actividades = Actividad::orderBy('nombre')->get();

    // Armar query con filtro por actividad si aplica
    $query = TurnoPlantilla::with(['actividad', 'instructor']);
    if ($actividadId) {
        $query->whereHas('actividad', function ($q) use ($actividadId) {
            $q->where('id_actividades', $actividadId);
        });
    }

    // Procesar turnos
    $turnos = $query->get()
        ->map(function ($plantilla) use ($inicioSemana, $finSemana, $usuarioId) {
            $offset = ($plantilla->dia_semana + 6) % 7;
            $fechaTurno = $inicioSemana->copy()->addDays($offset);

            if ($fechaTurno->gt($finSemana)) return null;

            $reserva = ReservaTurno::where('id_usuario', $usuarioId)
                ->where('id_turno_plantilla', $plantilla->id_turno_plantilla)
                ->where('fecha_turno', $fechaTurno->toDateString())
                ->first();

            $reservadas = ReservaTurno::where('id_turno_plantilla', $plantilla->id_turno_plantilla)
                ->where('fecha_turno', $fechaTurno->toDateString())
                ->where('estado', 'confirmada')
                ->count();

            $fechaTurno->locale('es');
            $diaTexto = ucfirst($fechaTurno->dayName) . ', ' . $fechaTurno->format('d') . ' de ' . $fechaTurno->translatedFormat('F');

            $estado = $this->calcularEstadoTurno($reserva, $fechaTurno, $plantilla);

            $plantilla->fecha_turno = $fechaTurno->toDateString();
            $plantilla->dia_texto = $diaTexto;
            $plantilla->estado = $estado;
            $plantilla->cupo_disponible = $plantilla->cupo - $reservadas;
            $plantilla->hora_texto = $plantilla->hora_inicio->format('H:i') . ' - ' . $plantilla->hora_fin->format('H:i');

            return $plantilla;
        })
        ->filter()
        ->sortBy(fn($t) => $t->fecha_turno)
        ->values();

    return view('Reservar_Turno.index', compact('turnos', 'semana', 'actividades', 'actividadId'));
}


    private function calcularEstadoTurno($reserva, $fechaTurno, $plantilla)
    {
        if ($reserva?->estado) return $reserva->estado;

        $horaInicio = Carbon::parse($fechaTurno->toDateString() . ' ' . $plantilla->hora_inicio->format('H:i'));
        $horaFin = Carbon::parse($fechaTurno->toDateString() . ' ' . $plantilla->hora_fin->format('H:i'));

        if (now()->lt($horaInicio)) return 'disponible';
        if (now()->between($horaInicio, $horaFin)) return 'en curso';
        return 'expirado';
    }

    public function reservar($id, $semana)
    {
        $usuarioId = Auth::id();
        $plantilla = TurnoPlantilla::findOrFail($id);

        // Calcular fechaTurno según la semana seleccionada
        if (preg_match('/^(\d{4})-W(\d{2})$/', $semana, $matches)) {
            $inicioSemana = Carbon::now()->setISODate($matches[1], $matches[2])->startOfWeek(Carbon::MONDAY);
        } else {
            $inicioSemana = Carbon::now()->startOfWeek(Carbon::MONDAY);
        }

        $fechaTurno = $inicioSemana->copy()->addDays(($plantilla->dia_semana + 6) % 7)->toDateString();

        // Validaciones
        if ($plantilla->usuarioYaReservo($fechaTurno, $usuarioId)) {
            return back()->withErrors(['error' => 'Ya reservaste ese turno.']);
        }

        if ($plantilla->cupoDisponible($fechaTurno) <= 0) {
            return back()->withErrors(['error' => 'No hay cupo disponible.']);
        }

        // Crear reserva
        ReservaTurno::create([
            'id_turno_plantilla' => $id,
            'id_usuario' => $usuarioId,
            'fecha_turno' => $fechaTurno,
            'estado' => 'confirmada',
        ]);

        return redirect()->route('reservar_turno.index', ['semana' => $semana])
            ->with('success', 'Reserva confirmada.');
    }
    public function cancelar($id)
    {
        $usuarioId = Auth::id();
        $plantilla = TurnoPlantilla::findOrFail($id);

        $fechaTurno = Carbon::now()
            ->startOfWeek(Carbon::MONDAY)
            ->addDays(($plantilla->dia_semana + 6) % 7)
            ->toDateString();

        $reserva = ReservaTurno::where('id_usuario', $usuarioId)
            ->where('id_turno_plantilla', $id)
            ->where('fecha_turno', $fechaTurno)
            ->where('estado', 'confirmada')
            ->first();

        if (!$reserva) {
            return back()->withErrors(['error' => 'No se encontró la reserva para cancelar.']);
        }

        try {
            $reserva->cancelar(); // delega al modelo
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al cancelar: ' . $e->getMessage()]);
        }

        return back()->with('success', 'Reserva cancelada correctamente.');
    }
}
