<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Turnos disponibles
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1e1e1e] overflow-hidden shadow-sm sm:rounded-lg shadow border border-gray-700">
                <div class="p-6 text-gray-100">

                    @if (session('success'))
                        <x-alertas.success>
                            {{ session('success') }}
                        </x-alertas.success>
                    @endif

                    {{-- Filtros --}}
                    <form method="GET" action="{{ route('reservar_turno.index') }}" class="flex flex-wrap gap-4 items-end mb-6">
                        {{-- Semana --}}
                        <div>
                            <label for="semana" class="block text-sm text-gray-300 mb-1">Semana:</label>
                            <input type="week" name="semana" id="semana" value="{{ $semana }}"
                                class="bg-[#121212] text-white border border-gray-600 rounded px-2 py-1">
                        </div>

                        {{-- Actividad --}}
                        <div>
                            <label for="actividad" class="block text-sm text-gray-300 mb-1">Actividad:</label>
                            <select name="actividad" id="actividad"
                                class="bg-[#121212] text-white border border-gray-600 rounded px-2 py-1">
                                <option value="">Todas</option>
                                @foreach($actividades as $actividad)
                                    <option value="{{ $actividad->id_actividades }}" {{ (string) request('actividad') === (string) $actividad->id_actividades ? 'selected' : '' }}>
                                        {{ $actividad->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-6 sm:mt-0">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow transition">
                                Filtrar
                            </button>
                        </div>
                    </form>

                    {{-- Rango seleccionado --}}
                    @if(request('semana'))
                        @php
                            $matches = [];
                            if (preg_match('/^(\d{4})-W(\d{2})$/', request('semana'), $matches)) {
                                $inicio = \Carbon\Carbon::now()->setISODate($matches[1], $matches[2])->startOfWeek();
                                $fin = $inicio->copy()->endOfWeek();
                            } else {
                                $inicio = null;
                                $fin = null;
                            }
                        @endphp

                        @if($inicio && $fin)
                            <div class="mb-4 text-gray-300">
                                <strong>Semana seleccionada:</strong> {{ $inicio->format('d/m/Y') }} al {{ $fin->format('d/m/Y') }}
                            </div>
                        @else
                            <div class="mb-4 text-red-500">
                                <strong>Formato de semana inválido.</strong>
                            </div>
                        @endif
                    @endif

                    {{-- Tabla --}}
                    <div class="overflow-x-auto">
                        <table class="w-full mt-4 border-collapse text-sm">
                            <thead>
                                <tr class="bg-[#2a2a2a] text-gray-300 uppercase text-xs">
                                    <th class="border border-gray-700 px-4 py-2">Actividad</th>
                                    <th class="border border-gray-700 px-4 py-2">Instructor</th>
                                    <th class="border border-gray-700 px-4 py-2">Día</th>
                                    <th class="border border-gray-700 px-4 py-2">Hora</th>
                                    <th class="border border-gray-700 px-4 py-2">Cupo</th>
                                    <th class="border border-gray-700 px-4 py-2">Estado</th>
                                    <th class="border border-gray-700 px-4 py-2 text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-200">
                                @forelse ($turnos as $turno)
                                    @php
                                        $reservasActuales = $turno->reservas()->where('fecha_turno', $turno->fecha_turno)->where('estado', 'confirmada')->count();
                                        $cupoDisponible = $turno->cupo - $reservasActuales;
                                        $yaReservado = $turno->reservas()->where('fecha_turno', $turno->fecha_turno)->where('id_usuario', auth()->id())->exists();
                                    @endphp
                                    <tr class="border border-gray-700 hover:bg-[#252525]">
                                        <td class="px-4 py-2">{{ $turno->actividad->nombre }}</td>
                                        <td class="px-4 py-2">{{ $turno->instructor->name }}</td>
                                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($turno->fecha_turno)->locale('es')->translatedFormat('l, d \d\e F') }}</td>
                                        <td class="px-4 py-2">{{ $turno->hora_texto }}</td>
                                        <td class="px-4 py-2">
                                            {{ $reservasActuales }} / {{ $turno->cupo }}
                                            @if($cupoDisponible <= 0)
                                                <span class="text-red-400 font-semibold ml-2">Sin cupo</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            @switch($turno->estado)
                                                @case('confirmada') <span class="text-green-400 font-semibold">Confirmada</span> @break
                                                @case('cancelada') <span class="text-red-400 font-semibold">Cancelada</span> @break
                                                @case('en curso') <span class="text-blue-400 font-semibold">En curso</span> @break
                                                @case('expirado') <span class="text-gray-500 font-semibold">Expirado</span> @break
                                                @default <span class="text-gray-400">Disponible</span>
                                            @endswitch
                                        </td>
                                        @if($permisos['puedeCrear'])
                                        <td class="px-4 py-2 text-center">
                                            @if($turno->estado === 'expirado')
                                                <span class="text-gray-500">Sin acción</span>
                                            @elseif(!$yaReservado && $cupoDisponible > 0)
                                                <form method="POST" action="{{ route('reservar_turno.reservar', ['id' => $turno->id_turno_plantilla, 'semana' => $semana]) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 shadow transition">
                                                        Reservar
                                                    </button>
                                                </form>
                                            @elseif($yaReservado)
                                                <form method="POST" action="{{ route('reservar_turno.cancelar', ['id' => $turno->id_turno_plantilla, 'semana' => $semana]) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 shadow transition">
                                                        Cancelar
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-500">Sin acción</span>
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-4 text-center text-gray-400 border border-gray-700">
                                            No hay turnos disponibles para la semana seleccionada.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @if($turnosPaginados->hasPages())
        <div class="mt-6 flex justify-center bg-[#2a2a2a] p-4 rounded shadow">
            {{ $turnosPaginados->appends(request()->query())->links() }}
        </div>
    @endif
</x-app-layout>
