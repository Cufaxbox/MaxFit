<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Mis Rutinas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1e1e1e] overflow-hidden shadow-sm sm:rounded-lg border border-gray-700">
                <div class="p-6 text-white">
                    @if (session('success'))
                        <x-alertas.success>
                            {{ session('success') }}
                        </x-alertas.success>
                    @endif

                    <table class="mt-4 w-full border-collapse border border-gray-700 text-sm">
                        <thead>
                            <tr class="bg-gray-800 text-gray-200 uppercase text-xs">
                                <th class="border border-gray-700 px-4 py-2">Asignado por instructor</th>
                                <th class="border border-gray-700 px-4 py-2 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rutinas as $rutina)
                                <tr class="border border-gray-700 hover:bg-gray-800">
                                    <td class="px-4 py-2">
                                        {{ $rutina->asignador->name ?? '—' }}
                                    </td>
                                    <td class="px-4 py-2 flex justify-center items-center space-x-2">
                                        <button type="button"
                                            class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow"
                                            onclick="document.getElementById('modal-{{ $rutina->id }}').showModal()">
                                            Ver
                                        </button>

                                        <!-- Modal -->
                                        <dialog id="modal-{{ $rutina->id }}" class="rounded-lg shadow-lg w-full max-w-md bg-[#1e1e1e] text-white overflow-y-auto max-h-[80vh] border border-gray-700">
                                            <div class="p-6">
                                                <h3 class="text-lg font-bold mb-4">Rutina asignada</h3>
                                                <p class="text-gray-300 whitespace-pre-line">{{ $rutina->descripcion }}</p>
                                                <hr class="my-4 border-gray-600">
                                                <p><strong>Asignada por:</strong> {{ $rutina->asignador->name ?? '—' }}</p>
                                                <div class="mt-4 text-right">
                                                    <button onclick="document.getElementById('modal-{{ $rutina->id }}').close()"
                                                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                                                        Cerrar
                                                    </button>
                                                </div>
                                            </div>
                                        </dialog>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if(method_exists($rutinas, 'links'))
                        <div class="mt-6 flex justify-center">
                            {{ $rutinas->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($rutinas->hasPages())
        <div class="mt-6 flex justify-center bg-[#2a2a2a] p-4 rounded shadow">
            {{ $rutinas->links() }}
        </div>
    @endif
</x-app-layout>
