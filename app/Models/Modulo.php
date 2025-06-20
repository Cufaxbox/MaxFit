<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model

{
    use HasFactory;

    protected $primaryKey = 'id_modulos'; // Definir la clave primaria correctamente
    protected $fillable = ['nombre', 'descripcion'];
    public $timestamps = false;

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'modulo_permiso_rol', 'id_modulos', 'id_permisos');
    }
}
