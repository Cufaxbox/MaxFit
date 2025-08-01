<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProtegePorPermiso
{
    public static function middlewarePorModulo(string $modulo): array
    {
        return [
            ['verificar.permiso:' . $modulo . ',Lectura', ['index', 'create', 'edit', 'show']],
            ['verificar.permiso:' . $modulo . ',Alta', ['store']],
            ['verificar.permiso:' . $modulo . ',Modificacion', ['update']],
            ['verificar.permiso:' . $modulo . ',Baja', ['destroy']],
        ];
    }

    public static function flagsPorModulo(string $modulo, ?User $usuario = null): array
    {
        /** @var User|null $usuario */
        $usuario = $usuario ?? Auth::user();

        return [
            'puedeVer' => $usuario?->tienePermiso($modulo, 'Lectura'),
            'puedeCrear' => $usuario?->tienePermiso($modulo, 'Alta'),
            'puedeEditar' => $usuario?->tienePermiso($modulo, 'Modificacion'),
            'puedeEliminar' => $usuario?->tienePermiso($modulo, 'Baja'),
        ];
    }
}
