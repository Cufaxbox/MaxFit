<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModuloPermisoRol;
use App\Models\Rol;
use App\Models\Modulo;
use App\Models\Permiso;

class ModuloPermisoRolController extends Controller
{
    public function index()
    {
        $asignaciones = ModuloPermisoRol::with('rol', 'modulo', 'permiso')->get();
        return view('modulo_permiso_rol.index', compact('asignaciones'));
    }

    public function create()
    {
        $roles = Rol::all();
        $modulos = Modulo::all();
        $permisos = Permiso::all();
        return view('modulo_permiso_rol.create', compact('roles', 'modulos', 'permisos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_roles' => 'required|exists:roles,id_roles',
            'id_modulos' => 'required|exists:modulos,id_modulos',
            'id_permisos' => 'required|exists:permisos,id_permisos',
        ]);

        ModuloPermisoRol::create($request->all());

        return redirect()->route('modulo-permiso-rol.index')->with('success', 'Asignación creada correctamente.');
    }

    public function destroy($id)
    {
        ModuloPermisoRol::findOrFail($id)->delete();
        return redirect()->route('modulo-permiso-rol.index')->with('success', 'Asignación eliminada.');
    }
}