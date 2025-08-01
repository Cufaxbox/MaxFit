<?php

namespace App\Http\Controllers;

use App\Models\TurnoPlantilla;
use App\Models\User;
use App\Models\Actividad;
use Illuminate\Http\Request;

use App\Http\Controllers\Traits\ProtegePorPermiso;


class TurnoPlantillaController extends Controller
{

    public function __construct()
    {
       // foreach (ProtegePorPermiso::middlewarePorModulo('TurnoPlantillas') as [$middleware, $actions]) {
       //     $this->middleware($middleware)->only($actions);
       // }

    }

    public function index()
    {
        $plantillas = TurnoPlantilla::with(['instructor', 'actividad'])->get();
        return view('turno_plantillas.index', compact('plantillas'));
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
}
