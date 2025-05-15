<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Editar Automatización
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('automations.update', $automation->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Nombre --}}
                    <div class="mb-4">
                        <label class="block font-semibold text-sm mb-1 text-gray-700 dark:text-gray-200">Nombre</label>
                        <input type="text" name="name" value="{{ $automation->name }}" required
                               class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>

                    {{-- Condición --}}
                    @php
                        $condition = json_decode($automation->conditions, true);
                    @endphp
                    <div class="mb-4">
                        <label class="block font-semibold text-sm mb-1 text-gray-700 dark:text-gray-200">Condición</label>
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                            <input type="text" name="sensor" placeholder="Sensor"
                                   value="{{ $condition['sensor'] ?? '' }}"
                                   class="w-full sm:w-auto rounded dark:bg-gray-700 dark:text-white">
                            <select name="operador" class="w-full sm:w-auto rounded dark:bg-gray-700 dark:text-white">
                                <option value="">-- Operador --</option>
                                <option value=">" {{ ($condition['operador'] ?? '') == '>' ? 'selected' : '' }}>Mayor que</option>
                                <option value="<" {{ ($condition['operador'] ?? '') == '<' ? 'selected' : '' }}>Menor que</option>
                                <option value="==" {{ ($condition['operador'] ?? '') == '==' ? 'selected' : '' }}>Igual a</option>
                            </select>
                            <input type="text" name="valor" placeholder="Valor"
                                   value="{{ $condition['valor'] ?? '' }}"
                                   class="w-full sm:w-auto rounded dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>

                    {{-- Acción --}}
                    @php
                        $action = json_decode($automation->action, true);
                    @endphp
                    <div class="mb-4">
                        <label class="block font-semibold text-sm mb-1 text-gray-700 dark:text-gray-200">Acción</label>
                        <div class="flex flex-col sm:flex-row gap-2">
                            <select name="device_id" class="w-full sm:w-auto rounded dark:bg-gray-700 dark:text-white">
                                <option value="">-- Dispositivo --</option>
                                @foreach ($devices as $device)
                                    <option value="{{ $device->id }}" {{ ($action['device_id'] ?? '') == $device->id ? 'selected' : '' }}>
                                        {{ $device->name }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="accion" class="w-full sm:w-auto rounded dark:bg-gray-700 dark:text-white">
                                <option value="">-- Acción --</option>
                                <option value="on" {{ ($action['accion'] ?? '') == 'on' ? 'selected' : '' }}>Encender</option>
                                <option value="off" {{ ($action['accion'] ?? '') == 'off' ? 'selected' : '' }}>Apagar</option>
                            </select>
                        </div>
                    </div>

                    {{-- Fecha y hora programada --}}
                    <div class="mb-4">
                        <label class="block font-semibold text-sm mb-1 text-gray-700 dark:text-gray-200">Fecha y hora</label>
                        <input type="datetime-local" name="time_program"
                               value="{{ $automation->time_program ? \Carbon\Carbon::parse($automation->time_program)->format('Y-m-d\TH:i') : '' }}"
                               class="w-full rounded dark:bg-gray-700 dark:text-white">
                    </div>

                    {{-- Botón --}}
                    <div class="text-right mt-6">
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
                            Actualizar
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
