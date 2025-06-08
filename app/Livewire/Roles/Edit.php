<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use App\Models\Rol;
use App\Models\Permiso;
use App\Models\Modulo;
use Illuminate\Support\Facades\DB;

class Edit extends Component
{
    public $rolId;
    public $nombre;
    public $descripcion;
    public $selectedModulos = [];
    public $selectedPermisos = [];
    public $permisos = [];
    public $modulos = [];

    public function mount($rolId)
    {
        $rol = Rol::findOrFail($rolId);

        //dump($rol->modulos); //  Ver si los módulos están cargando correctamente
        //dump($rol->modulos->pluck('permisos')); // Ver si los permisos aparecen dentro de los módulos
        $this->rolId = $rol->id_roles;
        $this->nombre = $rol->nombre;
        $this->descripcion = $rol->descripcion;
        $this->selectedModulos = $rol->modulos->pluck('id_modulos')->toArray();
        //$this->selectedModulos = $rol->modulos()->pluck('id_modulos')->toArray();
        //$this->selectedPermisos = $rol->permisos()->pluck('permisos.id_permisos')->toArray();


        $rol = Rol::with('modulos.permisos')->findOrFail($rolId); // Aseguramos que cargue correctamente

        $this->selectedPermisos = [];
        foreach ($rol->modulos as $modulo) {
            $this->selectedPermisos[$modulo->id_modulos] = [];
    
            foreach ($modulo->permisos as $permiso) {
                if (DB::table('modulo_permiso_rol')
                    ->where('id_roles', $this->rolId)
                    ->where('id_modulos', $modulo->id_modulos)
                    ->where('id_permisos', $permiso->id_permisos)
                    ->exists()) {
                $this->selectedPermisos[$modulo->id_modulos][$permiso->id_permisos] = true; 
        }
    }
}
    $this->permisos = Permiso::all();
    //dump($this->permisos);
    $this->modulos = Modulo::all();

    }

public function updateRole()
{
    $this->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string|max:1000',
        'selectedPermisos' => 'array',
        'selectedModulos' => 'array',
    ]);

    if (!$this->validarModulosConPermisos()) {
        session()->flash('error', 'Cada módulo debe tener al menos un permiso seleccionado.');
        return;
    }

    if (!$this->validarPermisosSinModulo()) {
        session()->flash('error', 'Hay permisos seleccionados que no pertenecen a ningún módulo válido.');
        return;
    }

    $rol = Rol::find($this->rolId);
    //if (!$rol) {
        //session()->flash('error', 'Rol no encontrado.');
        //return;
    //}

    $rol->update([
        'nombre' => $this->nombre,
        'descripcion' => $this->descripcion ?? '',
    ]);

    // Obtener permisos actuales en la BD
    $permisosActuales = DB::table('modulo_permiso_rol')
        ->where('id_roles', $rol->id_roles)
        ->pluck('id_permisos', 'id_modulos')
        ->toArray();

    //Eliminar permisos que ya no están seleccionados
    DB::table('modulo_permiso_rol')
        ->where('id_roles', $rol->id_roles)
        ->whereNotIn('id_modulos', $this->selectedModulos)
        ->delete();

    DB::table('modulo_permiso_rol')
        ->where('id_roles', $rol->id_roles)
        ->whereNotIn('id_permisos', array_merge(...array_values($this->selectedPermisos)))
        ->delete();

    // 🚀 Insertar solo los permisos nuevos
    $datos = [];
    foreach ($this->selectedModulos as $modulo_id) {
        if (isset($this->selectedPermisos[$modulo_id])) {
            foreach (array_keys($this->selectedPermisos[$modulo_id]) as $permiso_id) {
                if (!isset($permisosActuales[$modulo_id]) || $permisosActuales[$modulo_id] !== $permiso_id) {
                    $datos[] = [
                        'id_roles' => $this->rolId,
                        'id_modulos' => $modulo_id,
                        'id_permisos' => $permiso_id
                    ];
                }
            }
        }
    }

    if (!empty($datos)) {
        DB::table('modulo_permiso_rol')->insert($datos);
    }

    return redirect()->route('roles.index')->with('success', 'Rol Actualizado correctamente.');
}

    public function render()
    {
        return view('livewire.roles.edit');
    }

        //  Verifica que cada módulo tenga al menos un permiso seleccionado
private function validarModulosConPermisos(): bool
{
        if (empty($this->selectedModulos) || empty($this->selectedPermisos)) {
            session()->flash('error', 'Debes seleccionar al menos un módulo y un permiso antes de guardar.');
            return false;
        }

    foreach ($this->selectedModulos as $modulo_id) {
        //dump($this->selectedModulos);
        //dump($this->selectedPermisos);
        if (!isset($this->selectedPermisos[$modulo_id]) || empty($this->selectedPermisos[$modulo_id])) {
            session()->flash('error', "El módulo '{$this->modulos->find($modulo_id)->nombre}' no tiene permisos seleccionados.");
            return false;
        }
    }
    return true; // Todo correcto
}

//  Verifica que no haya permisos seleccionados sin un módulo
private function validarPermisosSinModulo(): bool
{

    foreach ($this->selectedPermisos as $modulo_id => $permisos) {
        if (!in_array($modulo_id, $this->selectedModulos)) {
            session()->flash('error', "Hay permisos seleccionados que no pertenecen a ningún módulo válido.");
            return false;
        }
    }
    return true; // Todo correcto
}
}
