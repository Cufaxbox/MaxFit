<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TurnoPlantilla extends Model
{
    protected $table = 'turno_plantillas';
    protected $primaryKey = 'id_turno_plantilla';

    protected $fillable = [
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'cupo',
        'instructor_id',
        'id_actividad',
    ];

    protected $casts = [
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
    ];

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function actividad(): BelongsTo
    {
        return $this->belongsTo(Actividad::class, 'id_actividad');
    }

    public function getNombreDiaAttribute(): string
    {
        $dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        return $dias[$this->dia_semana] ?? 'Día inválido';
    }
}