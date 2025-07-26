<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class UsuariosController extends Controller
{
    public function index()
    {
        $actividades = User::all();
        return view('actividades.index', compact('actividades'));
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

        User::create(['nombre' => $request->nombre]); // Guardar solo 'nombre'

        return redirect()->route('actividades.index')->with('success', 'Actividad creada correctamente.');
    }


    public function edit($id)
    {
        $actividad = User::findOrFail($id);
        return view('actividades.edit', compact('actividad'));
    }

    public function update(Request $request, $id)
    {
        $actividad = User::findOrFail($id);
        $actividad->update($request->all());
        return redirect()->route('actividades.index')->with('success', 'Actividad actualizada.');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('actividades.index')->with('success', 'Actividad eliminada.');
    }
}
