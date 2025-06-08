<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuloPermisoRol extends Model
{
    use HasFactory;

    protected $table = 'modulo_permiso_rol';
    protected $primaryKey = 'id_modulo_permiso_rol';
    public $timestamps = false;

    protected $fillable = ['id_roles', 'id_modulos', 'id_permisos'];

    // Relación con Roles
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_roles');
    }

    // Relación con Módulos
    public function modulo()
    {
        return $this->belongsTo(Modulo::class, 'id_modulos');
    }

    // Relación con Permisos
    public function permiso()
    {
        return $this->belongsTo(Permiso::class, 'id_permisos');
    }
}