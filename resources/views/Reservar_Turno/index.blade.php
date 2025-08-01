<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Turnos disponibles
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Alertas de éxito --}}
                    @if (session('success'))
                    <x-alertas.success>
                        {{ session('success') }}
                    </x-alertas.success>
                    @endif

                    <form method="GET" action="{{ route('reservar_turno.index') }}" class="flex gap-4 items-center mb-4">
                        {{-- Filtro por semana --}}
                        <label for="semana">Semana:</label>
                        <input type="week" name="semana" id="semana" value="{{ $semana }}" class="border px-2 py-1">

                        {{-- Filtro por categoría --}}
                        <label for="actividad">Actividades:</label>
                        <select name="actividad" id="actividad" class="border px-2 py-1">
                            <option value="">Todas</option>
                            @foreach($actividades as $actividad)
                            <option value="{{ $actividad->id_actividades }}" {{ (string) request('actividad') === (string) $actividad->id_actividades ? 'selected' : '' }}>
                                {{ $actividad->nombre }}
                            </option>
                            @endforeach
                        </select>

                        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                            Filtrar
                        </button>
                    </form>

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
                    <div class="mb-4 text-gray-700">
                        <strong>Semana seleccionada:</strong> {{ $inicio->format('d/m/Y') }} al {{ $fin->format('d/m/Y') }}
                    </div>
                    @else
                    <div class="mb-4 text-red-600">
                        <strong>Formato de semana inválido.</strong>
                    </div>
                    @endif
                    @endif

                    {{-- Tabla de turnos --}}
                    <table class="mt-4 w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-300 px-4 py-2">Actividad</th>
                                <th class="border border-gray-300 px-4 py-2">Instructor</th>
                                <th class="border border-gray-300 px-4 py-2">Día</th>
                                <th class="border border-gray-300 px-4 py-2">Hora</th>
                                <th class="border border-gray-300 px-4 py-2">Cupo</th>
                                <th class="border border-gray-300 px-4 py-2">Estado</th>
                                <th class="border border-gray-300 px-4 py-2">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($turnos as $turno)
                            @php
                            $reservasActuales = $turno->reservas()
                            ->where('fecha_turno', $turno->fecha_turno)
                            ->where('estado', 'confirmada')
                            ->count();

                            $cupoDisponible = $turno->cupo - $reservasActuales;

                            $yaReservado = $turno->reservas()
                            ->where('fecha_turno', $turno->fecha_turno)
                            ->where('id_usuario', auth()->id())
                            ->exists();
                            @endphp
                            <tr>
                                <td class="border px-4 py-2">{{ $turno->actividad->nombre }}</td>
                                <td class="border px-4 py-2">{{ $turno->instructor->name}}</td>
                                <td class="border px-4 py-2">
                                    {{ \Carbon\Carbon::parse($turno->fecha_turno)->locale('es')->translatedFormat('l, d \d\e F') }}
                                </td>
                                <td class="border px-4 py-2">{{ $turno->hora_texto }}</td>
                                <td class="border px-4 py-2">
                                    {{ $reservasActuales }} / {{ $turno->cupo }}
                                    @if($cupoDisponible <= 0)
                                        <span class="text-red-600 font-semibold ml-2">Sin cupo</span>
                                        @endif
                                </td>
                                <td class="border px-4 py-2">
                                    @switch($turno->estado)
                                    @case('confirmada')
                                    <span class="text-green-600 font-semibold">Confirmada</span>
                                    @break
                                    @case('cancelada')
                                    <span class="text-red-600 font-semibold">Cancelada</span>
                                    @break
                                    @case('en curso')
                                    <span class="text-blue-600 font-semibold">En curso</span>
                                    @break
                                    @case('expirado')
                                    <span class="text-gray-400 font-semibold">Expirado</span>
                                    @break
                                    @default
                                    <span class="text-gray-600">Disponible</span>
                                    @endswitch
                                </td>
                                <td class="border px-4 py-2">
                                    @if($turno->estado === 'expirado')
                                    <span class="text-gray-400">Sin acción</span>
                                    @elseif(!$yaReservado && $cupoDisponible > 0)

                                    <form method="POST" action="{{ route('reservar_turno.reservar', ['id' => $turno->id_turno_plantilla, 'semana' => $semana]) }}">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                            Reservar</button>
                                    </form>
                                    @elseif($yaReservado)
                                    <form method="POST" action="{{ route('reservar_turno.cancelar', ['id' => $turno->id_turno_plantilla, 'semana' => $semana]) }}">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                            Cancelar</button>
                                    </form>
                                    @else
                                    <span class="text-gray-400">Sin acción</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="border px-4 py-2 text-center text-gray-500">
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
</x-app-layout>