<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ProtegePorPermiso;
use App\Models\Rutina;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RutinaController extends Controller
{

    public array $permisos;

    public function __construct()
    {
        foreach (ProtegePorPermiso::middlewarePorModulo('Rutinas') as [$middleware, $actions]) {
            $this->middleware($middleware)->only($actions);
        }
    }

    public function mount()
    {
        $this->permisos = ProtegePorPermiso::flagsPorModulo('Rutinas');
    }

    public function index(Request $request)
    {
        $permisos = ProtegePorPermiso::flagsPorModulo('Rutinas');

        $usuarios = User::query()
            ->when($request->filled('tipo'), function ($q) use ($request) {
                $q->whereHas('rol', function ($q2) use ($request) {
                    $tipo = strtolower($request->tipo);

                    // Filtramos por nombre del rol (insensible a mayúsculas)
                    $q2->whereRaw('LOWER(nombre) = ?', [$tipo]);

                    // Extra: si querés seguir usando el flag es_instructor también:
                    if ($tipo === 'cliente') {
                        $q2->where('es_instructor', false);
                    } elseif ($tipo === 'instructor') {
                        $q2->where('es_instructor', true);
                    }
                });
            })
            ->when($request->filled('email'), function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->email . '%');
            })
            ->get();

        $rutinas = Rutina::all();

        return view('rutinas.index', compact('rutinas', 'permisos', 'usuarios'));
    }


    public function create(Request $request)
    {
        $clienteId = $request->get('cliente_id');
        $cliente = User::findOrFail($clienteId);
        return view('rutinas.create', compact('cliente'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'cliente_id' => 'required|exists:users,id',
        ]);

        Rutina::create([
            'descripcion' => $request->descripcion,
            'cliente_id' => $request->cliente_id,
            'asignado_por_id' => Auth::id(), // 👈 el usuario logueado

        ]);

        return redirect()->route('rutinas.index')->with('success', 'Rutina asignada con éxito.');
    }

    public function edit($id)
    {
        $rutina = Rutina::findOrFail($id);
        return view('rutinas.edit', compact('rutina'));
    }

    public function update(Request $request, $id)
    {
        $rutina = Rutina::findOrFail($id);

        $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        $rutina->update([
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('rutinas.index')->with('success', 'Rutina actualizada correctamente.');
    }


    public function createParaUsuario($usuarioId)
    {
        $cliente = User::findOrFail($usuarioId);
        return view('rutinas.create', compact('cliente'));
    }

    public function editParaUsuario($usuarioId)
    {
        $cliente = User::findOrFail($usuarioId);
        $rutina = Rutina::where('cliente_id', $usuarioId)->first();

        if (!$rutina) {
            return redirect()->back()->with('error', 'Este usuario aún no tiene rutina asignada.');
        }

        return view('rutinas.edit', compact('cliente', 'rutina'));
    }

}
