<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lista de Clientes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <x-alertas.success>
                            {{ session('success') }}
                        </x-alertas.success>
                    @endif

                    <form method="GET" action="{{ route('rutinas.index') }}" class="mb-4 flex items-center gap-4 flex-wrap">
                        <!-- Filtro por tipo -->
                        <div>
                            <label for="tipo" class="mr-2 font-semibold">Filtrar por Tipo:</label>
                            <select name="tipo" id="tipo" class="border border-gray-300 rounded p-2 px-8">
                                <option value="">Todos</option>
                                @foreach(\App\Models\Rol::all() as $rol)
                                    <option value="{{ strtolower($rol->nombre) }}" {{ request('tipo') === strtolower($rol->nombre) ? 'selected' : '' }}>
                                        {{ $rol->nombre }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <!-- Búsqueda -->
                        <div>
                            <label for="email" class="mr-2 font-semibold">Buscar:</label>
                            <input type="text" name="email" id="email" value="{{ request('email') }}"
                                placeholder="ejemplo@email.com"
                                class="border border-gray-300 rounded p-2" />
                        </div>

                        <!-- Botón -->
                        <button type="submit" class="px-4 py-2 bg-indigo-500 text-white rounded">Filtrar</button>
                    </form>


                    <table class="mt-4 w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-300 px-4 py-2">Nombre</th>
                                <th class="border border-gray-300 px-4 py-2">Email</th>
                                <th class="border border-gray-300 px-4 py-2">Rol</th>
                                <th class="border border-gray-300 px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr class="border border-gray-300">
                                    <td class="px-4 py-2">{{ $usuario->name }}</td>
                                    <td class="px-4 py-2">{{ $usuario->email }}</td>
                                    <td class="px-4 py-2">{{ $usuario->rol_nombre ?? '-' }}</td>
                                    <td class="px-4 py-2 flex justify-center items-center space-x-2">
                                        @php
                                            $tieneRutina = $rutinas->contains('cliente_id', $usuario->id);
                                        @endphp

                                        @if (!$tieneRutina)
                                            <a href="{{ route('usuarios.rutinas.create', $usuario->id) }}" wire:navigate
                                                class="px-4 py-2 bg-blue-500 text-white font-bold rounded-lg shadow-md hover:bg-blue-600">
                                                Asignar Rutina
                                            </a>
                                        @endif

                                        @if ($tieneRutina)
                                            <a href="{{ route('usuarios.rutinas.edit', $usuario->id) }}" wire:navigate
                                                class="px-4 py-2 bg-green-500 text-white font-bold rounded-lg shadow-md hover:bg-green-600">
                                                Editar Rutina
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
