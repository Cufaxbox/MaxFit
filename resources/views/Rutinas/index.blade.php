<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Lista de Clientes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1e1e1e] overflow-hidden shadow-sm sm:rounded-lg border border-gray-700">
                <div class="p-6 text-white">
                    @if (session('success'))
                        <x-alertas.success>
                            {{ session('success') }}
                        </x-alertas.success>
                    @endif

                    <form method="GET" action="{{ route('rutinas.index') }}" class="mb-6 flex items-center gap-4 flex-wrap">
                        <div>
                            <label for="tipo" class="mr-2 font-semibold text-white">Filtrar por Tipo:</label>
                            <select name="tipo" id="tipo" class="bg-gray-900 border border-gray-700 text-white rounded px-4 py-2">
                                <option value="">Todos</option>
                                @foreach(\App\Models\Rol::all() as $rol)
                                    <option value="{{ strtolower($rol->nombre) }}" {{ request('tipo') === strtolower($rol->nombre) ? 'selected' : '' }}>
                                        {{ $rol->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="email" class="mr-2 font-semibold text-white">Buscar:</label>
                            <input type="text" name="email" id="email" value="{{ request('email') }}"
                                placeholder="ejemplo@email.com"
                                class="bg-gray-900 border border-gray-700 text-white rounded px-4 py-2" />
                        </div>

                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded px-6 py-2 shadow">
                            Filtrar
                        </button>
                    </form>

                    <table class="mt-4 w-full border-collapse border border-gray-700 text-sm">
                        <thead>
                            <tr class="bg-gray-800 text-gray-200 uppercase text-xs">
                                <th class="border border-gray-700 px-4 py-2">Nombre</th>
                                <th class="border border-gray-700 px-4 py-2">Email</th>
                                <th class="border border-gray-700 px-4 py-2">Rol</th>
                                <th class="border border-gray-700 px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr class="border border-gray-700 hover:bg-gray-800">
                                    <td class="px-4 py-2">{{ $usuario->name }}</td>
                                    <td class="px-4 py-2">{{ $usuario->email }}</td>
                                    <td class="px-4 py-2">{{ $usuario->rol_nombre ?? '-' }}</td>
                                    <td class="px-4 py-2 flex justify-center items-center space-x-2">
                                        @php
                                            $tieneRutina = $rutinas->contains('cliente_id', $usuario->id);
                                        @endphp

                                        @if (!$tieneRutina)
                                            <a href="{{ route('usuarios.rutinas.create', $usuario->id) }}" wire:navigate
                                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow">
                                                Asignar Rutina
                                            </a>
                                        @endif

                                        @if ($tieneRutina)
                                            <a href="{{ route('usuarios.rutinas.edit', $usuario->id) }}" wire:navigate
                                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow">
                                                Editar Rutina
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($usuarios->hasPages())
                        <div class="mt-6 flex justify-center">
                            {{ $usuarios->appends(request()->query())->links('pagination::tailwind') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
