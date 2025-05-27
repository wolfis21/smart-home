<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Mis Dispositivos') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mx-auto max-w-7xl">

                <!-- Contenedor buscador + agregar -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-4">
                    <form method="GET" action="{{ route('devices.index') }}" class="flex flex-row w-full gap-2">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Buscar por nombre o tipo..."
                            class="flex-1 px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600"
                        >
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition shrink-0">
                            Buscar
                        </button>
                    </form>

                    <a href="{{ route('devices.create') }}"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded text-sm transition text-center w-full sm:w-auto">
                        + Agregar dispositivo
                    </a>
                </div>

                @if($devices->isEmpty())
                    <p class="text-gray-600 dark:text-gray-300 text-center">No tienes dispositivos registrados.</p>
                @else
                    <!-- Contenedor para scroll horizontal -->
                <div class="overflow-x-auto">
                    <table class="min-w-full text-gray-800 dark:text-gray-100">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-center">ID</th>
                                <th class="px-4 py-2 text-center">Nombre</th>
                                <th class="px-4 py-2 text-center">Tipo</th>
                                <th class="px-4 py-2 text-center">Estado</th>
                                <th class="px-4 py-2 text-center">Ubicación</th>
                                <th class="px-4 py-2 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($devices as $device)
                                <tr class="border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300">
                                    <td class="px-4 py-2 text-center font-bold text-blue-600 dark:text-blue-400">{{ $device->id }}</td>
                                    <td class="px-4 py-2 text-center">{{ $device->name }}</td>
                                    <td class="px-4 py-2 text-center">{{ $device->type }}</td>
                                    <td class="px-4 py-2 text-center">{{ $device->status }}</td>
                                    <td class="px-4 py-2 text-center">{{ $device->location }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex flex-wrap justify-center gap-2">
                                            <form action="{{ route('devices.toggle', $device->id) }}" method="POST" class="flex">
                                                @csrf
                                                @method('PUT')
                                                <button class="text-sm min-w-[110px] text-center h-10 px-3 bg-blue-500 hover:bg-blue-600 text-white rounded transition-transform transform hover:scale-105">
                                                    {{ $device->status === 'activo' ? 'Apagar' : 'Encender' }}
                                                </button>
                                            </form>

                                            <a href="{{ route('devices.edit', $device->id) }}" 
                                            class="text-sm min-w-[110px] text-center content-center h-10 px-3 bg-gray-600 hover:bg-gray-700 text-white rounded transition-transform transform hover:scale-105">
                                            Editar
                                            </a>

                                            <form action="{{ route('devices.destroy', $device->id) }}" method="POST" class="flex"
                                                onsubmit="return confirm('¿Estás seguro de eliminar este dispositivo?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="text-sm min-w-[110px] text-center h-10 px-3 bg-red-600 hover:bg-red-700 text-white rounded transition-transform transform hover:scale-105">
                                                    Eliminar
                                                </button>
                                            </form>

                                            <a href="{{ route('consumes.show', $device->id) }}" 
                                            class="text-sm min-w-[110px] text-center content-center h-10 px-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded transition-transform transform hover:scale-105">
                                            Ver consumo
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            <div class="mt-4">
                {{ $devices->links() }}
            </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
