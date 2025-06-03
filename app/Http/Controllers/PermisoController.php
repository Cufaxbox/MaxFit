<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class PermisoController extends Controller
{
    public function index() {
        $permisos = Permiso::all();
        return view('permisos.index', compact('permisos'));
    }

    public function create() {
        return view('permisos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:45', 
    ]);

    Permiso::create(['nombre' => $request->nombre]); // Guardar solo 'nombre'

    return redirect()->route('permisos.index')->with('success', 'Permiso creado correctamente.');
}


    public function edit($id) {
        $permiso = Permiso::findOrFail($id);
        return view('permisos.edit', compact('permiso'));
    }

    public function update(Request $request, $id) {
        $permiso = Permiso::findOrFail($id);
        $permiso->update($request->all());
        return redirect()->route('permisos.index')->with('success', 'Permiso actualizado.');
    }

    public function destroy($id) {
        Permiso::destroy($id);
        return redirect()->route('permisos.index')->with('success', 'Permiso eliminado.');
    }
}