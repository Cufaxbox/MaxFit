<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Nueva Plantilla de Turno
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1e1e1e] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <form action="{{ route('turno_plantillas.store') }}" method="POST">
                        @csrf

                        {{-- Día de la semana --}}
                        <div class="mb-4">
                            <label for="dia_semana" class="block text-gray-300 mb-1">Día de la semana:</label>
                            <select name="dia_semana" id="dia_semana"
                                    class="bg-[#121212] text-white border border-gray-600 rounded w-full p-2"
                                    required>
                                @foreach(['0' => 'Domingo', '1' => 'Lunes', '2' => 'Martes', '3' => 'Miércoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sábado'] as $key => $dia)
                                    <option value="{{ $key }}" {{ old('dia_semana') == $key ? 'selected' : '' }}>
                                        {{ $dia }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dia_semana') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Hora inicio --}}
                        <div class="mb-4">
                            <label for="hora_inicio" class="block text-gray-300 mb-1">Hora de inicio:</label>
                            <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio') }}"
                                   class="bg-[#121212] text-white border border-gray-600 rounded w-full p-2" required>
                            @error('hora_inicio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Hora fin --}}
                        <div class="mb-4">
                            <label for="hora_fin" class="block text-gray-300 mb-1">Hora de fin:</label>
                            <input type="time" name="hora_fin" id="hora_fin" value="{{ old('hora_fin') }}"
                                   class="bg-[#121212] text-white border border-gray-600 rounded w-full p-2" required>
                            @error('hora_fin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Cupo --}}
                        <div class="mb-4">
                            <label for="cupo" class="block text-gray-300 mb-1">Cupo máximo:</label>
                            <input type="number" name="cupo" id="cupo" value="{{ old('cupo') }}"
                                   class="bg-[#121212] text-white border border-gray-600 rounded w-full p-2"
                                   min="1" required>
                            @error('cupo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Instructor --}}
                        <div class="mb-4">
                            <label for="instructor_id" class="block text-gray-300 mb-1">Instructor:</label>
                            <select name="instructor_id" id="instructor_id"
                                    class="bg-[#121212] text-white border border-gray-600 rounded w-full p-2" required>
                                @foreach ($instructores as $instructor)
                                    <option value="{{ $instructor->id }}" {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                        {{ $instructor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('instructor_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Actividad --}}
                        <div class="mb-4">
                            <label for="id_actividad" class="block text-gray-300 mb-1">Actividad:</label>
                            <select name="id_actividad" id="id_actividad"
                                    class="bg-[#121212] text-white border border-gray-600 rounded w-full p-2" required>
                                <option value="">— Seleccionar —</option>
                                @foreach ($actividades as $actividad)
                                    <option value="{{ $actividad->id_actividades }}" {{ old('id_actividad') == $actividad->id_actividades ? 'selected' : '' }}>
                                        {{ $actividad->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_actividad') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Botones --}}

                        <a href="{{ route('turno_plantillas.index') }}" wire:navigate
                           class="px-4 py-2 bg-red-700 text-white rounded-md hover:bg-gray-800 transition font-medium ml-2">
                            Cancelar
                        </a>

                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition font-medium">
                            Guardar Plantilla
                        </button>

    
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
