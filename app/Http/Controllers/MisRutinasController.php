<?php

namespace App\Http\Controllers;

use App\Models\Rutina;
use Illuminate\Http\Request;
use App\Http\Helpers\ProtegePorPermiso;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MisRutinasController extends Controller
{

        public function __construct()
    {
        foreach (ProtegePorPermiso::middlewarePorModulo('Mis Rutinas') as [$middleware, $actions]) {
            $this->middleware($middleware)->only($actions);
        }
    }

    public function index()
    {

        $permisos = ProtegePorPermiso::flagsPorModulo('Mis Rutinas');

        $idUsuario = optional(Auth::user())->id;

        $rutinas = Rutina::with('asignador')
        ->where('cliente_id', $idUsuario)
        ->paginate(10);

        return view('mis_rutinas.index', compact('rutinas'));
    }
}
