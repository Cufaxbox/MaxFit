<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Usuario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('usuarios.update', ['usuario' => $usuario->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nombre -->
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Nombre:</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $usuario->name) }}"
                                class="border border-gray-300 rounded w-full p-2" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700">Email:</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $usuario->email) }}"
                                class="border border-gray-300 rounded w-full p-2" required>
                        </div>

                        <!-- Rol -->
                        <div class="mb-4">
                            <label for="rol_id" class="block text-gray-700">Rol:</label>
                            <select name="rol_id" id="rol_id" class="border border-gray-300 rounded w-full p-2" required>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->id_roles }}"
                                        {{ $usuario->rol->contains($rol) ? 'selected' : '' }}>
                                        {{ $rol->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Botón de actualizar -->
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 text-white font-bold rounded-lg shadow-md hover:bg-green-600">
                            Actualizar Usuario
                        </button>

                        <a href="{{ route('usuarios.index') }}" wire:navigate
                            class="px-4 py-2 bg-blue-500 text-white font-bold rounded-lg shadow-md hover:bg-blue-600">
                            Cancelar
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
