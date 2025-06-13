<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use App\Models\Rol;
use App\Models\Permiso;
use App\Models\Modulo;
use App\Models\Actividad;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public $isProcessing = false;
    public $nombre;
    public $descripcion;
    public $selectedPermisos = [];
    public $selectedModulos = [];
    public $permisos = [];
    public $modulos = [];

    //Cargar permisos y módulos cuando se monta el componente
    public function mount()
    {
        $this->permisos = Permiso::select('id_permisos', 'nombre')->get();
        $this->modulos = Modulo::select('id_modulos', 'nombre')->get();
    }

    //Método para guardar el rol y sus relaciones en la tabla intermedia
    public function saveRole()
    {


        $this->isProcessing = true;


        $this->validate([
            'nombre' => 'required|string|max:45',
            'descripcion' => 'nullable|string|max:45',
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



        //Crear el rol en la base de datos
        $rol = Rol::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
        ])->fresh(); // 🚀 Asegura que Laravel recupere el ID correctamente

        //dd($rol->id, $rol->id_roles);
        //Insertar registros en la tabla intermedia `modulo_permiso_rol`
        foreach ($this->selectedModulos as $modulo_id) {
            if (isset($this->selectedPermisos[$modulo_id])) {
                //dump("Procesando módulo: {$modulo_id}");
                foreach (array_keys($this->selectedPermisos[$modulo_id]) as $permiso_id) {
                    //dump("Insertando módulo {$modulo_id}, permiso {$permiso_id}"); // 🚀 Ver cada permiso en la consola
                    DB::table('modulo_permiso_rol')->insert([
                        'id_roles' => $rol->id_roles,
                        'id_modulos' => $modulo_id,
                        'id_permisos' => $permiso_id
                    ]);
                }
            }
        }



        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function render()
    {
        return view('livewire.roles.create', [
            'permisos' => $this->permisos,
            'modulos' => $this->modulos,
        ]);
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
