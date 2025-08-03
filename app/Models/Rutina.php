<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rutina extends Model
{
    use HasFactory;

    protected $table = 'rutinas'; // nombre de la tabla
    protected $primaryKey = 'id'; // clave primaria
    protected $fillable = ['descripcion', 'cliente_id', 'asignado_por_id'];


    public $timestamps = false;

    // Relación con el cliente (usuario)
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    //Relacion quein asigno
    public function asignador()
    {
        return $this->belongsTo(User::class, 'asignado_por_id');
    }
}
