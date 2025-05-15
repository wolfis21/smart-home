<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Agregar Dispositivo') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 p-6 rounded shadow">
            <form method="POST" action="{{ route('devices.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Nombre</label>
                    <input type="text" name="name" required
                        class="w-full mt-1 px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Tipo</label>
                    <input type="text" name="type" required
                        class="w-full mt-1 px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Ubicación</label>
                    <input type="text" name="location"
                        class="w-full mt-1 px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Protocolo</label>
                    <input type="text" name="protocol"
                        class="w-full mt-1 px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white">
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('devices.index') }}" class="text-gray-600 dark:text-gray-300 hover:underline mr-4 content-center">Cancelar</a>
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
