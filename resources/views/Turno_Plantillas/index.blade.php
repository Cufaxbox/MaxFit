<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Configuración de Turnos
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1e1e1e] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    @if (session('success'))
                        <x-alertas.success>
                            {{ session('success') }}
                        </x-alertas.success>
                    @endif

                    @if($permisos['puedeCrear'])
                        <a href="{{ route('turno_plantillas.create') }}" wire:navigate
                           class="inline-block mb-4 px-4 py-2 bg-yellow-500 text-black font-medium rounded-md shadow hover:bg-yellow-600 transition">
                            + Nueva Plantilla de Turno
                        </a>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-300 border border-gray-700">
                            <thead class="bg-gray-800 text-gray-300">
                                <tr>
                                    <th class="px-4 py-3 border-b border-gray-700">Día</th>
                                    <th class="px-4 py-3 border-b border-gray-700">Inicio</th>
                                    <th class="px-4 py-3 border-b border-gray-700">Fin</th>
                                    <th class="px-4 py-3 border-b border-gray-700">Cupo</th>
                                    <th class="px-4 py-3 border-b border-gray-700">Instructor</th>
                                    <th class="px-4 py-3 border-b border-gray-700">Actividad</th>
                                    <th class="px-4 py-3 border-b border-gray-700 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                                @endphp

                                @foreach ($plantillas as $plantilla)
                                    <tr class="hover:bg-gray-900 transition">
                                        <td class="px-4 py-2 border-b border-gray-700">{{ $dias[$plantilla->dia_semana] ?? 'Día inválido' }}</td>
                                        <td class="px-4 py-2 border-b border-gray-700">{{ \Carbon\Carbon::parse($plantilla->hora_inicio)->format('H:i') }}</td>
                                        <td class="px-4 py-2 border-b border-gray-700">{{ \Carbon\Carbon::parse($plantilla->hora_fin)->format('H:i') }}</td>
                                        <td class="px-4 py-2 border-b border-gray-700">{{ $plantilla->cupo }}</td>
                                        <td class="px-4 py-2 border-b border-gray-700">{{ $plantilla->instructor->name ?? '—' }}</td>
                                        <td class="px-4 py-2 border-b border-gray-700">{{ $plantilla->actividad->nombre ?? '—' }}</td>
                                        <td class="px-4 py-2 border-b border-gray-700 flex justify-center items-center gap-2">
                                            @if($permisos['puedeEditar'])
                                                <a href="{{ route('turno_plantillas.edit', ['turno_plantilla' => $plantilla->id_turno_plantilla]) }}"
                                                   wire:navigate
                                                   class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition font-medium">
                                                    Editar
                                                </a>
                                            @endif

                                            @if($permisos['puedeEliminar'])
                                                <form action="{{ route('turno_plantillas.destroy', ['turno_plantilla' => $plantilla->id_turno_plantilla]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            onclick="return confirm('¿Estás seguro de que querés eliminar esta plantilla?')"
                                                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition font-medium">
                                                        Eliminar
                                                    </button>
                                                </form>
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
    </div>
    @if($plantillas->hasPages())
    <div class="mt-6 flex justify-center bg-gray-100 p-4 rounded shadow">
        {{ $plantillas->links() }}
    </div>
    @endif
</x-app-layout>
