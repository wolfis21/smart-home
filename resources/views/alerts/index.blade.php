<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Alertas de Dispositivos') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensaje de éxito --}}
            @if (session('status'))
                <div class="mb-6">
                    <div class="bg-green-100 border border-green-400 text-green-700 dark:bg-green-800 dark:text-green-100 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            {{-- 🔵 Filtro de dispositivos --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <form method="GET" action="{{ route('alerts.index') }}" class="flex flex-col sm:flex-row items-stretch gap-2 w-full md:w-auto">
                        <select name="device_id"
                            class="px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600 text-sm">
                            <option value="">-- Todos los Dispositivos --</option>
                            @foreach($devices as $device)
                                <option value="{{ $device->id }}" {{ request('device_id') == $device->id ? 'selected' : '' }}>
                                    {{ $device->name }}
                                </option>
                            @endforeach
                        </select>

                        <div class="flex gap-2 w-full sm:w-auto">
                            <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm text-center">
                                Filtrar
                            </button>

                            <a href="{{ route('alerts.index') }}"
                            class="flex items-center justify-center gap-2 flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded text-sm text-center group">
                                
                                {{-- Icono refresh más clásico --}}
<!--                                 <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582M20 20v-5h-.581M19.418 19.418A8.003 8.003 0 014.582 4.582" />
                                </svg> -->
                                <i class="fa fa-refresh fa-spin"></i>
                                Resetear
                            </a>

                        </div>
                    </form>

                    {{-- Botón limpiar alertas --}}
                    <form method="POST" action="{{ route('alerts.clear') }}"
                        onsubmit="return confirm('¿Estás seguro que deseas eliminar las alertas?')" class="flex">
                        @csrf
                        @method('DELETE')

                        <input type="hidden" name="device_id" value="{{ request('device_id') }}">

                        <button type="submit"
                            class="group flex items-center justify-center gap-2 flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm transition-all duration-300">
                            
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                class="fill-white h-4 w-4 transition-transform duration-300 group-hover:translate-x-1">
                                <path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                            </svg>

                            Limpiar Alertas
                        </button>
                    </form>
                    {{-- Botón de descargar reporte PDF --}}
                        <a href="{{ route('report.alerts.pdf') }}"
                        class="group flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-4 w-4" viewBox="0 0 512 512">
                                <path d="M480 448H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32zM240 0c-13.3 0-24 10.7-24 24V342.1l-73.4-73.4c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l112 112c9.4 9.4 24.6 9.4 33.9 0l112-112c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L272 342.1V24c0-13.3-10.7-24-24-24z"/>
                            </svg>
                            Descargar Reporte de Alertas (PDF)
                        </a>
                </div>
            </div>

            {{-- 🔵 Tabla de alertas --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($alerts->isEmpty())
                    <p class="text-gray-600 dark:text-gray-300 text-center">No se han generado alertas aún.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-gray-800 dark:text-gray-100">
                            <thead>
                                <tr class="text-center text-sm font-semibold uppercase tracking-wide">
                                    <th class="px-4 py-2">Dispositivo</th>
                                    <th class="px-4 py-2">Tipo de Alerta</th>
                                    <th class="px-4 py-2">Mensaje</th>
                                    <th class="px-4 py-2 text-center">
                                        Nivel
                                        <div class="flex justify-center mt-2 gap-1">
                                            <a href="{{ route('alerts.index', array_merge(request()->only('device_id'), ['level' => 'alto'])) }}"
                                                class="bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded">
                                                Alto
                                            </a>

                                            <a href="{{ route('alerts.index', array_merge(request()->only('device_id'), ['level' => 'medio'])) }}"
                                                class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-2 py-1 rounded">
                                                Medio
                                            </a>

                                            <a href="{{ route('alerts.index', array_merge(request()->only('device_id'), ['level' => 'bajo'])) }}"
                                                class="bg-green-500 hover:bg-green-600 text-white text-xs px-2 py-1 rounded">
                                                Bajo
                                            </a>
                                        </div>
                                    </th>
                                    <th class="px-4 py-2">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alerts as $alert)
                                    <tr class="border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300">
                                        <td class="px-4 py-2 text-center">{{ $alert->device->name ?? 'Dispositivo eliminado' }}</td>
                                        <td class="px-4 py-2 text-center">{{ $alert->type_alert }}</td>
                                        <td class="px-4 py-2 text-center">{{ $alert->message }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                @if($alert->level === 'alto') bg-red-100 text-red-800
                                                @elseif($alert->level === 'medio') bg-yellow-100 text-yellow-800
                                                @else bg-green-100 text-green-800
                                                @endif">
                                                {{ ucfirst($alert->level) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 text-center">{{ \Carbon\Carbon::parse($alert->created_at)->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginación --}}
                    <div class="mt-6">
                        {{ $alerts->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
