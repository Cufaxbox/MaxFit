<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades'; // Definir la tabla correcta
    protected $primaryKey = 'id_actividades'; // Definir la clave primaria correctamente
    protected $fillable = ['nombre']; // Asegurar que solo se guarde nombre
    public $timestamps = false;
}
