<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Mis Automatizaciones') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 🔵 Botón Crear Automatización --}}
            <div class="mb-6">
                <a href="{{ route('automations.create') }}"
                   class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded text-sm">
                    + Nueva Automatización
                </a>
            </div>

            {{-- 🔵 Card de Tabla --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($automations->isEmpty())
                    <p class="text-gray-600 dark:text-gray-300 text-center">No has creado automatizaciones aún.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-gray-800 dark:text-gray-100">
                            <thead>
                                <tr class="text-center text-sm font-semibold uppercase tracking-wide">
                                    <th class="px-4 py-2">Nombre</th>
                                    <th class="px-4 py-2">Condiciones</th>
                                    <th class="px-4 py-2">Acciones</th>
                                    <th class="px-4 py-2">Programado</th>
                                    <th class="px-4 py-2">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($automations as $automation)
                                    <tr class="border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300">
                                        <td class="px-4 py-2 text-center">{{ $automation->name }}</td>
<!--                                         <td class="px-4 py-2 text-center">
                                            <pre class="text-xs whitespace-pre-wrap">{{ json_encode($automation->conditions, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <pre class="text-xs whitespace-pre-wrap">{{ json_encode($automation->action, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                        </td> -->
                                        <td class="px-4 py-2 text-center">
                                            @if(!empty($automation->formatted_conditions))
                                                @foreach($automation->formatted_conditions as $condition)
                                                    <span class="inline-block bg-gray-300 dark:bg-gray-700 px-2 py-1 rounded m-1 text-xs">
                                                        {{ $condition }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-xs">Sin condiciones</span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-2 text-center">
                                            @if(!empty($automation->formatted_action))
                                                @foreach($automation->formatted_action as $action)
                                                    <span class="inline-block bg-gray-300 dark:bg-gray-700 px-2 py-1 rounded m-1 text-xs">
                                                        {{ $action }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-xs">Sin acciones</span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-2 text-center">
                                            {{ $automation->time_program ? \Carbon\Carbon::parse($automation->time_program)->format('d/m/Y H:i') : 'No programado' }}
                                        </td>
                                        <td class="px-4 py-2 text-center space-x-2">
                                            <a href="{{ route('automations.edit', $automation) }}"
                                               class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">
                                                Editar
                                            </a>

                                            <form action="{{ route('automations.destroy', $automation) }}" method="POST" class="inline-block"
                                                  onsubmit="return confirm('¿Seguro que deseas eliminar esta automatización?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- 🔵 Paginación --}}
                    <div class="mt-6">
                        {{ $automations->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
