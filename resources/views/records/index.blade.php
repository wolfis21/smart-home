<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Historial de Actividad') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 🔵 Card principal --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($records->isEmpty())
                    <p class="text-gray-600 dark:text-gray-300 text-center">No hay actividades registradas aún.</p>
                @else
                    <div class="overflow-x-auto">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow mb-6">
                            <form method="GET" action="{{ route('records.index') }}" class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                <select name="type"
                                    class="px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600 text-sm">
                                    <option value="">-- Todos los eventos --</option>
                                    <option value="dispositivo" {{ request('type') == 'dispositivo' ? 'selected' : '' }}>Dispositivos</option>
                                    <option value="alerta" {{ request('type') == 'alerta' ? 'selected' : '' }}>Alertas</option>
                                    <option value="sesion" {{ request('type') == 'sesion' ? 'selected' : '' }}>Sesiones</option>
                                </select>

                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
                                    Filtrar
                                </button>

                                <a href="{{ route('records.index') }}"
                                    class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded text-sm text-center">
                                    <i class="fa fa-refresh fa-spin"></i>
                                    Resetear
                                </a>
                            </form>
                        </div>

                        <table class="min-w-full text-gray-800 dark:text-gray-100">
                            <thead>
                                <tr class="text-center text-sm font-semibold uppercase tracking-wide">
                                    <th class="px-4 py-2">Evento</th>
                                    <th class="px-4 py-2">Descripción</th>
                                    <th class="px-4 py-2">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($records as $record)
                                    <tr class="border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300">
                                        <td class="px-4 py-2 text-center">{{ $record->event }}</td>
                                        <td class="px-4 py-2 text-center">{{ $record->description ?? '-' }}</td>
                                        <td class="px-4 py-2 text-center">{{ \Carbon\Carbon::parse($record->date_event)->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- 🔵 Paginación --}}
                    <div class="mt-6">
                        {{ $records->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
