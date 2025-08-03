<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis Turnos
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

                    <table class="mt-4 w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-300 px-4 py-2">Actividad</th>
                                <th class="border border-gray-300 px-4 py-2">Instructor</th>
                                <th class="border border-gray-300 px-4 py-2">Fecha</th>
                                <th class="border border-gray-300 px-4 py-2">Hora</th>
                                <th class="border border-gray-300 px-4 py-2">Estado</th>
                                <th class="border border-gray-300 px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($turnos as $turno)
                                @php
                                    $plantilla = $turno->turnoPlantilla;
                                    $horaInicio = \Carbon\Carbon::parse($plantilla->hora_inicio)->format('H:i');
                                    $horaFin = \Carbon\Carbon::parse($plantilla->hora_fin)->format('H:i');

                                    $fecha = \Carbon\Carbon::parse($turno->fecha_turno)->format('Y-m-d');
                                    $hora = \Carbon\Carbon::parse($plantilla->hora_fin)->format('H:i:s');
                                    $fechaHoraFin = \Carbon\Carbon::parse("$fecha $hora");

                                    $yaPaso = $fechaHoraFin->isPast();
                                @endphp
                                <tr class="border border-gray-300">
                                    <td class="px-4 py-2">
                                        {{ $plantilla->actividad->nombre ?? '—' }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $plantilla->instructor->name ?? '—' }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ \Carbon\Carbon::parse($turno->fecha_turno)->locale('es')->translatedFormat('l d \d\e F') }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $horaInicio }} - {{ $horaFin }}
                                    </td>
                                    <td class="px-4 py-2">
                                        @switch($turno->estado)
                                            @case('confirmada')
                                                <span class="text-green-600 font-semibold">Confirmada</span>
                                                @break
                                            @case('cancelada')
                                                <span class="text-red-600 font-semibold">Cancelada</span>
                                                @break
                                            @case('expirado')
                                                <span class="text-gray-400 font-semibold">Expirado</span>
                                                @break
                                            @default
                                                <span class="text-gray-600">Pendiente</span>
                                        @endswitch
                                    </td>
                                    <td class="px-4 py-2 flex justify-center items-center space-x-2">
                                        @if(($permisos['puedeEliminar'] ?? false) && !$yaPaso && $turno->estado !== 'expirado')
                                            <form action="{{ route('mis_turnos.destroy', ['mis_turno' => $turno->id_turno_plantilla]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-4 py-2 bg-red-500 text-white font-bold rounded-lg shadow-md hover:bg-red-600">
                                                    Cancelar
                                                </button>
                                            </form>
                                        @else
                                            <span class="px-2 py-1 bg-gray-200 text-gray-600 text-sm rounded">Expirado</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if(method_exists($turnos, 'links'))
                        <div class="mt-4">
                            {{ $turnos->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if($turnos->hasPages())
    <div class="mt-6 flex justify-center bg-gray-100 p-4 rounded shadow">
        {{ $turnos->links() }}
    </div>
    @endif
</x-app-layout>