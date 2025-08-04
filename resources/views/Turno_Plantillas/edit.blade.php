<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Editar Plantilla de Turno
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1e1e1e] overflow-hidden shadow sm:rounded-lg border border-gray-700">
                <div class="p-6 text-gray-100">
                    <form action="{{ route('turno_plantillas.update', ['turno_plantilla' => $plantilla->id_turno_plantilla]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Día de la semana --}}
                        <label for="dia_semana" class="block text-sm text-gray-300 mb-1">Día de la semana:</label>
                        <select name="dia_semana" id="dia_semana" class="bg-[#121212] text-white border border-gray-600 rounded w-full px-3 py-2" required>
                            @foreach(['0' => 'Domingo', '1' => 'Lunes', '2' => 'Martes', '3' => 'Miércoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sábado'] as $key => $dia)
                                <option value="{{ $key }}" {{ $plantilla->dia_semana == $key ? 'selected' : '' }}>{{ $dia }}</option>
                            @endforeach
                        </select>

                        {{-- Hora inicio --}}
                        <label for="hora_inicio" class="block text-sm text-gray-300 mt-4 mb-1">Hora de inicio:</label>
                        <input type="time" name="hora_inicio" id="hora_inicio"
                            value="{{ \Carbon\Carbon::parse($plantilla->hora_inicio)->format('H:i') }}"
                            class="bg-[#121212] text-white border border-gray-600 rounded w-full px-3 py-2" required>

                        {{-- Hora fin --}}
                        <label for="hora_fin" class="block text-sm text-gray-300 mt-4 mb-1">Hora de fin:</label>
                        <input type="time" name="hora_fin" id="hora_fin"
                            value="{{ \Carbon\Carbon::parse($plantilla->hora_fin)->format('H:i') }}"
                            class="bg-[#121212] text-white border border-gray-600 rounded w-full px-3 py-2" required>

                        {{-- Cupo --}}
                        <label for="cupo" class="block text-sm text-gray-300 mt-4 mb-1">Cupo máximo:</label>
                        <input type="number" name="cupo" id="cupo" value="{{ $plantilla->cupo }}"
                            class="bg-[#121212] text-white border border-gray-600 rounded w-full px-3 py-2" min="1" required>

                        {{-- Instructor --}}
                        <label for="instructor_id" class="block text-sm text-gray-300 mt-4 mb-1">Instructor:</label>
                        <select name="instructor_id" id="instructor_id" class="bg-[#121212] text-white border border-gray-600 rounded w-full px-3 py-2" required>
                            @foreach ($instructores as $instructor)
                                <option value="{{ $instructor->id }}" {{ $plantilla->instructor_id == $instructor->id ? 'selected' : '' }}>
                                    {{ $instructor->name }}
                                </option>
                            @endforeach
                        </select>

                        {{-- Actividad --}}
                        <label for="id_actividad" class="block text-sm text-gray-300 mt-4 mb-1">Actividad:</label>
                        <select name="id_actividad" id="id_actividad" class="bg-[#121212] text-white border border-gray-600 rounded w-full px-3 py-2" required>
                            <option value="">— Seleccionar —</option>
                            @foreach ($actividades as $actividad)
                                <option value="{{ $actividad->id_actividades }}" {{ $plantilla->id_actividad == $actividad->id_actividades ? 'selected' : '' }}>
                                    {{ $actividad->nombre }}
                                </option>
                            @endforeach
                        </select>

                        {{-- Botones --}}
                        <div class="mt-6 flex gap-4">
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded shadow transition">
                                Actualizar Plantilla
                            </button>

                            <a href="{{ route('turno_plantillas.index') }}" wire:navigate
                               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow transition">
                                Cancelar
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
