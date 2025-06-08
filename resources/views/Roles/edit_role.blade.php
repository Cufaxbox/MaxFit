<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Actulizar Rol
        </h2>
    </x-slot>
    <div class="py-4">
        <livewire:roles.edit :rolId="$rol->id_roles" />
    </div>
</x-app-layout>