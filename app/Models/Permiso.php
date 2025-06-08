<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_permisos'; // Definir la clave primaria correctamente
    protected $fillable = ['nombre']; // Asegurar que solo se guarde nombre
    public $timestamps = false;
}
