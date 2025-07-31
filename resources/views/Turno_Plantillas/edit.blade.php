<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Plantilla de Turno
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('turno_plantillas.update', ['turno_plantilla' => $plantilla->id_turno_plantilla]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Día de la semana --}}
                        <label for="dia_semana" class="block text-gray-700">Día de la semana:</label>
                        <select name="dia_semana" id="dia_semana" class="border border-gray-300 rounded w-full p-2" required>
                            @foreach(['0' => 'Domingo', '1' => 'Lunes', '2' => 'Martes', '3' => 'Miércoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sábado'] as $key => $dia)
                            <option value="{{ $key }}" {{ $plantilla->dia_semana == $key ? 'selected' : '' }}>{{ $dia }}</option>
                            @endforeach
                        </select>

                        {{-- Hora inicio --}}
                        <label for="hora_inicio" class="block text-gray-700 mt-4">Hora de inicio:</label>
                        <input type="time" name="hora_inicio" id="hora_inicio"
                            value="{{ \Carbon\Carbon::parse($plantilla->hora_inicio)->format('H:i') }}"
                            class="border border-gray-300 rounded w-full p-2" required>

                        {{-- Hora fin --}}
                        <label for="hora_fin" class="block text-gray-700 mt-4">Hora de fin:</label>
                        <input type="time" name="hora_fin" id="hora_fin"
                            value="{{ \Carbon\Carbon::parse($plantilla->hora_fin)->format('H:i') }}"
                            class="border border-gray-300 rounded w-full p-2" required>

                        {{-- Cupo --}}
                        <label for="cupo" class="block text-gray-700 mt-4">Cupo máximo:</label>
                        <input type="number" name="cupo" id="cupo" value="{{ $plantilla->cupo }}"
                            class="border border-gray-300 rounded w-full p-2" min="1" required>

                        {{-- Instructor --}}
                        <label for="instructor_id" class="block text-gray-700 mt-4">Instructor:</label>
                        <select name="instructor_id" id="instructor_id" class="border border-gray-300 rounded w-full p-2" required>
                            @foreach ($instructores as $instructor)
                            <option value="{{ $instructor->id }}" {{ $plantilla->instructor_id == $instructor->id ? 'selected' : '' }}>
                                {{ $instructor->name }}
                            </option>
                            @endforeach
                        </select>

                        {{-- Actividad --}}
                        <label for="id_actividad" class="block text-gray-700 mt-4">Actividad:</label>
                        <select name="id_actividad" id="id_actividad" class="border border-gray-300 rounded w-full p-2" required>
                            <option value="">— Seleccionar —</option>
                            @foreach ($actividades as $actividad)
                            <option value="{{ $actividad->id_actividades }}" {{ $plantilla->id_actividad == $actividad->id_actividades ? 'selected' : '' }}>
                                {{ $actividad->nombre }}
                            </option>
                            @endforeach
                        </select>
                        {{-- Botones --}}
                        <div class="mt-6">
                            <button type="submit"
                                class="px-4 py-2 bg-green-500 text-white font-bold rounded-lg shadow-md hover:bg-green-600">
                                Actualizar Plantilla
                            </button>

                            <a href="{{ route('turno_plantillas.index') }}" wire:navigate
                                class="px-4 py-2 bg-blue-500 text-white font-bold rounded-lg shadow-md hover:bg-blue-600">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>