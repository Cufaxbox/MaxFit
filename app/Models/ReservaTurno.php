<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ReservaTurno extends Model
{
    protected $table = 'reserva_turnos';
    protected $primaryKey = 'id_reserva_turno';

    protected $fillable = [
        'id_turno_plantilla',
        'id_usuario',
        'fecha_turno',
        'estado',
        'fecha_reserva',
    ];

    // Relaciones
    public function turnoPlantilla()
    {
        return $this->belongsTo(TurnoPlantilla::class, 'id_turno_plantilla', 'id_turno_plantilla');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }

    // Scope para filtrar solo reservas confirmadas
    public function scopeActivas(Builder $query): Builder
    {
        return $query->where('estado', 'confirmada');
    }

    // Helper para saber si está cancelada
    public function estaCancelada(): bool
    {
        return $this->estado === 'cancelada';
    }

    public static function tieneReserva($idUsuario, $idTurnoPlantilla, $fechaTurno): bool
    {
        return self::where('id_usuario', $idUsuario)
            ->where('id_turno_plantilla', $idTurnoPlantilla)
            ->where('fecha_turno', $fechaTurno)
            ->where('estado', 'confirmada')
            ->exists();
    }

    // app/Models/ReservaTurno.php

    public function cancelar(): void
    {
        if ($this->estado !== 'confirmada') {
            throw new \Exception('Solo se pueden cancelar reservas confirmadas.');
        }

        $this->estado = 'cancelada';
        $this->save();
    }

}
