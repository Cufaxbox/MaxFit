<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = 'id_roles';
    protected $fillable = ['nombre', 'descripcion'];
    public $timestamps = false;

    public function modulos()
    {
        return $this->belongsToMany(Modulo::class, 'modulo_permiso_rol', 'id_roles', 'id_modulos');
    }

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'modulo_permiso_rol', 'id_roles', 'id_permisos');
    }
}
