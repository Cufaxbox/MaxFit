<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use Illuminate\Http\Request;

class ModuloController extends Controller
{
    public function index()
    {
        $modulos = Modulo::all();
        return view('modulos.index', compact('modulos'));
    }

    public function create()
    {
        return view('modulos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:modulos',
            'descripcion' => 'nullable',
        ]);

        Modulo::create($request->all());
        return redirect()->route('modulos.index')->with('success', 'Modulo creado correctamente.');
    }

    public function edit($id)
    {
        $modulo = Modulo::findOrFail($id);
        return view('modulos.edit', compact('modulo'));
    }

    public function update(Request $request, $id_modulos)
    {
        $modulo = Modulo::findOrFail($id_modulos);
        $modulo->update($request->all());

        return redirect()->route('modulos.index')->with('success', 'Módulo actualizado correctamente.');
    }

    public function destroy(Modulo $modulo)
    {
        $modulo->delete();
        return redirect()->route('modulos.index')->with('success', 'Módulo eliminado.');
    }
}
