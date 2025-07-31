<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nueva Plantilla de Turno
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('turno_plantillas.store') }}" method="POST">
                        @csrf

                        {{-- Día de la semana --}}
                        <div class="mb-4">
                            <label for="dia_semana" class="block text-gray-700">Día de la semana:</label>
                            <select name="dia_semana" id="dia_semana" class="border border-gray-300 rounded w-full p-2" required>
                                @foreach(['0' => 'Domingo', '1' => 'Lunes', '2' => 'Martes', '3' => 'Miércoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sábado'] as $key => $dia)
                                <option value="{{ $key }}" {{ old('dia_semana') == $key ? 'selected' : '' }}>{{ $dia }}</option>
                                @endforeach
                            </select>
                            @error('dia_semana') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Hora inicio --}}
                        <div class="mb-4">
                            <label for="hora_inicio" class="block text-gray-700">Hora de inicio:</label>
                            <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio') }}"
                                class="border border-gray-300 rounded w-full p-2" required>
                            @error('hora_inicio') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Hora fin --}}
                        <div class="mb-4">
                            <label for="hora_fin" class="block text-gray-700">Hora de fin:</label>
                            <input type="time" name="hora_fin" id="hora_fin" value="{{ old('hora_fin') }}"
                                class="border border-gray-300 rounded w-full p-2" required>
                            @error('hora_fin') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Cupo --}}
                        <div class="mb-4">
                            <label for="cupo" class="block text-gray-700">Cupo máximo:</label>
                            <input type="number" name="cupo" id="cupo" value="{{ old('cupo') }}"
                                class="border border-gray-300 rounded w-full p-2" min="1" required>
                            @error('cupo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Instructor --}}
                        <div class="mb-4">
                            <label for="instructor_id" class="block text-gray-700">Instructor:</label>
                            <select name="instructor_id" id="instructor_id" class="border border-gray-300 rounded w-full p-2" required>
                                @foreach ($instructores as $instructor)
                                <option value="{{ $instructor->id }}" {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                    {{ $instructor->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('instructor_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Actividad --}}
                        <div class="mb-4">
                            <label for="id_actividad" class="block text-gray-700">Actividad:</label>
                            <select name="id_actividad" id="id_actividad" class="border border-gray-300 rounded w-full p-2" required>
                                <option value="">— Seleccionar —</option>
                                @foreach ($actividades as $actividad)
                                <option value="{{ $actividad->id_actividades }}" {{ old('id_actividad') == $actividad->id_actividades ? 'selected' : '' }}>
                                    {{ $actividad->nombre }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_actividad') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Botones --}}
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700">
                            Guardar Plantilla
                        </button>

                        <a href="{{ route('turno_plantillas.index') }}" wire:navigate
                            class="px-4 py-2 bg-blue-500 text-white font-bold rounded-lg shadow-md hover:bg-blue-600">
                            Cancelar
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>