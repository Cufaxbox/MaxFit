<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Rol;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create_role');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:45|unique:roles,nombre',
            'descripcion' => 'nullable|string|max:45',
        ]);

        Rol::create($request->all());

        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function edit($id)
    {
        $rol = Rol::findOrFail($id); 
        return view('roles.edit_role', compact('rol')); 
    }


    public function update(Request $request, $id)
    {
        $rol = Rol::findOrFail($id);
        $rol->update($request->all());

        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }

public function destroy($id)
{
    $rol = Rol::find($id);

    if (!$rol) {
        return redirect()->route('roles.index')->with('error', 'Rol no encontrado.');
    }

    // Eliminar relaciones en `modulo_permiso_rol`
    DB::table('modulo_permiso_rol')->where('id_roles', $rol->id_roles)->delete();

    // Eliminar el rol
    $rol->delete();

    return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
}
}