<?php

namespace App\Http\Controllers;

use App\Models\TurnoPlantilla;
use App\Models\User;
use App\Models\Actividad;
use Illuminate\Http\Request;

use App\Http\Helpers\ProtegePorPermiso;


class TurnoPlantillaController extends Controller
{

    public array $permisos;

    public function __construct()
    {
        foreach (ProtegePorPermiso::middlewarePorModulo('Configurar Turnos') as [$middleware, $actions]) {
            $this->middleware($middleware)->only($actions);
        }
    }

    public function mount()
    {
        $this->permisos = ProtegePorPermiso::flagsPorModulo('Configurar Turnos');
    }


    public function index()
    {
        //$plantillas = TurnoPlantilla::with(['instructor', 'actividad'])->get();
        $plantillas = TurnoPlantilla::with(['instructor', 'actividad'])->paginate(10);
        $permisos = ProtegePorPermiso::flagsPorModulo('Configurar Turnos');

        return view('turno_plantillas.index', compact('plantillas', 'permisos'));
    }


    public function create()
    {
        $instructores = User::instructores()->with('rol')->get();
        $actividades = Actividad::orderBy('nombre')->get();

        return view('turno_plantillas.create', compact('instructores', 'actividades'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'dia_semana'     => 'required|integer|between:0,6',
            'hora_inicio'    => 'required|date_format:H:i',
            'hora_fin'       => 'required|date_format:H:i|after:hora_inicio',
            'cupo'           => 'required|integer|min:1',
            'instructor_id'  => 'required|exists:users,id',
            //'id_actividad' => 'required|exists:actividades,id_actividades',
            'id_actividad' => 'required|exists:actividades,id_actividades',

        ]);

        ///Validamos que no se pueda dar un instructor mismo dia y fecha
        if ($this->hayColisionDeTurno($request->only(['dia_semana', 'hora_inicio', 'hora_fin', 'instructor_id']))) {
            return back()->withErrors([
                'instructor_id' => 'Este instructor ya tiene un turno asignado en ese horario y día.',
            ])->withInput();
        }


        TurnoPlantilla::create([
            'dia_semana'     => (int) $request->dia_semana,
            'hora_inicio'    => $request->hora_inicio,
            'hora_fin'       => $request->hora_fin,
            'cupo'           => (int) $request->cupo,
            'instructor_id'  => (int) $request->instructor_id,
            'id_actividad'   => (int) $request->id_actividad,
        ]);

        return redirect()->route('turno_plantillas.index')
            ->with('success', 'Turno plantilla creado correctamente.');
    }

    public function edit($id)
    {
        $plantilla = TurnoPlantilla::findOrFail($id);
        $instructores = User::instructores()->with('rol')->get();
        $actividades = Actividad::orderBy('nombre')->get();

        return view('turno_plantillas.edit', compact('plantilla', 'instructores', 'actividades'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'dia_semana'     => 'required|integer|between:0,6',
            'hora_inicio'    => 'required|date_format:H:i',
            'hora_fin'       => 'required|date_format:H:i|after:hora_inicio',
            'cupo'           => 'required|integer|min:1',
            'instructor_id'  => 'required|exists:users,id',
            //'id_actividad' => 'required|exists:actividades,id_actividades',
            'id_actividad' => 'required|exists:actividades,id_actividades',

        ]);

        ///Validamos que no se pueda dar un instructor mismo dia y fecha
        if ($this->hayColisionDeTurno($request->only(['dia_semana', 'hora_inicio', 'hora_fin', 'instructor_id']))) {
            return back()->withErrors([
                'instructor_id' => 'Este instructor ya tiene un turno asignado en ese horario y día.',
            ])->withInput();
        }

        $plantilla = TurnoPlantilla::findOrFail($id);
        $plantilla->update([
            'dia_semana'     => (int) $request->dia_semana,
            'hora_inicio'    => $request->hora_inicio,
            'hora_fin'       => $request->hora_fin,
            'cupo'           => (int) $request->cupo,
            'instructor_id'  => (int) $request->instructor_id,
            'id_actividad'   => (int) $request->id_actividad,
        ]);

        return redirect()->route('turno_plantillas.index')
            ->with('success', 'Turno plantilla actualizada correctamente.');
    }

    public function destroy($id)
    {
        TurnoPlantilla::destroy($id);
        return redirect()->route('turno_plantillas.index')
            ->with('success', 'Turno plantilla eliminada.');
    }

    private function hayColisionDeTurno(array $datos, ?int $excluirId = null): bool
    {
        return TurnoPlantilla::where('dia_semana', $datos['dia_semana'])
            ->where('instructor_id', $datos['instructor_id'])
            ->when($excluirId, fn($q) => $q->where('id', '!=', $excluirId))
            ->where(function ($query) use ($datos) {
                $query->whereBetween('hora_inicio', [$datos['hora_inicio'], $datos['hora_fin']])
                    ->orWhereBetween('hora_fin', [$datos['hora_inicio'], $datos['hora_fin']])
                    ->orWhere(function ($q) use ($datos) {
                        $q->where('hora_inicio', '<=', $datos['hora_inicio'])
                            ->where('hora_fin', '>=', $datos['hora_fin']);
                    });
            })
            ->exists();
    }
}
