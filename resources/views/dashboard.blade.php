<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#121212] min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#212121]/80 backdrop-blur-md shadow-xl sm:rounded-xl border border-gray-700">
                <div class="dashboard-card">
    {{ __("¡Estás dentro! Bienvenido al panel de control.") }}
            </div>
            </div>
        </div>
    </div>

</x-app-layout>