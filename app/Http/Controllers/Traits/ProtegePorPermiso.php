<?php

namespace App\Http\Controllers\Traits;

trait ProtegePorPermiso
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

}