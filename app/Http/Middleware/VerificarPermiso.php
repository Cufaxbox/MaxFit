<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class VerificarPermiso
{
    public function handle($request, Closure $next, $modulo, $permiso)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user || !$user->tienePermiso($modulo, $permiso)) {
            abort(403, 'No tenés permiso para acceder a esta página.');
        }

        return $next($request);
    }
}
