<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\ProtegePorPermiso;

class ActividadController extends Controller
{

    public array $permisos;

    public function __construct()
    {
        foreach (ProtegePorPermiso::middlewarePorModulo('Actividades') as [$middleware, $actions]) {
            $this->middleware($middleware)->only($actions);
        }
    }

        public function mount()
    {
        $this->permisos = ProtegePorPermiso::flagsPorModulo('Actividades');
    }


    public function index()
    {
        $permisos = ProtegePorPermiso::flagsPorModulo('Actividades');
        $actividades = Actividad::all();
        return view('actividades.index', compact('actividades','permisos'));
    }


    public function create()
    {
        return view('actividades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:45',
        ]);

        Actividad::create(['nombre' => $request->nombre]); // Guardar solo 'nombre'

        return redirect()->route('actividades.index')->with('success', 'Actividad creada correctamente.');
    }


    public function edit($id)
    {
        $actividad = Actividad::findOrFail($id);
        return view('actividades.edit', compact('actividad'));
    }

    public function update(Request $request, $id)
    {
        $actividad = Actividad::findOrFail($id);
        $actividad->update($request->all());
        return redirect()->route('actividades.index')->with('success', 'Actividad actualizada.');
    }

    public function destroy($id)
    {
        Actividad::destroy($id);
        return redirect()->route('actividades.index')->with('success', 'Actividad eliminada.');
    }
}
