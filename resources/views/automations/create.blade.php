<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Crear Automatización
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('automations.store') }}">
                    @csrf

                    {{-- Nombre --}}
                    <div class="mb-4">
                        <label class="block font-semibold text-sm mb-1 text-gray-700 dark:text-gray-200">Nombre</label>
                        <input type="text" name="name" required
                               class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>

                    {{-- Condición simple --}}
                    <div class="mb-4">
                        <label class="block font-semibold text-sm mb-1 text-gray-700 dark:text-gray-200">Condición</label>
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                            <select name="sensor" class="w-full sm:w-auto rounded dark:bg-gray-700 dark:text-white">
                                <option value="">-- Sensor --</option>
                                <option value="temperatura">Temperatura</option>
                                <option value="hora">Hora</option>
                            </select>

                            <select name="operador" class="w-full sm:w-auto rounded dark:bg-gray-700 dark:text-white">
                                <option value="">-- Operador --</option>
                                <option value=">">Mayor que</option>
                                <option value="<">Menor que</option>
                                <option value="==">Igual a</option>
                            </select>

                            <select name="temperatura" class="w-full sm:w-auto rounded dark:bg-gray-700 dark:text-white">
                             <option value="" disabled selected>--Seleccione--</option>
                             <option value="0">0°C</option>
                             <option value="5">5°C</option>
                             <option value="10">10°C</option>
                             <option value="15">15°C</option>
                             <option value="20">20°C</option>
                            <option value="25">25°C</option>
                            <option value="30">30°C</option>
                            <option value="35">35°C</option>
                            <option value="40">40°C</option>
                             <option value="45">45°C</option>
                            </select>
                        </div>
                    </div>

                    {{-- Acción simple --}}
                    <div class="mb-4">
                        <label class="block font-semibold text-sm mb-1 text-gray-700 dark:text-gray-200">Acción</label>
                        <div class="flex flex-col sm:flex-row gap-2">
                        <select name="device_id" class="w-full sm:w-auto rounded dark:bg-gray-700 dark:text-white bg-white text-black">
                            <option value="">-- Dispositivo --</option>
                            @foreach ($devices as $device)
                                <option value="{{ $device->id }}">{{ $device->name }}</option>
                            @endforeach
                        </select>


                            <select name="accion" class="w-full sm:w-auto rounded dark:bg-gray-700 dark:text-white">
                                <option value="">-- Acción --</option>
                                <option value="on">Encender</option>
                                <option value="off">Apagar</option>
                                <option value="Notification">Notificar</option>
                            </select>
                        </div>
                    </div>

                    {{-- Fecha y hora programada --}}
                        <div class="mb-4">
                            <label class="block font-semibold text-sm mb-1 text-gray-200">Fecha y hora</label>
                            <input type="datetime-local" name="time_program" id="time_program"
                                class="w-full rounded dark:bg-gray-700 dark:text-white">
                        </div>

                        {{-- Checkbox ejecutar siempre --}}
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="execute_always" id="execute_always" class="form-checkbox text-blue-600" checked>
                                <span class="ml-2 text-white">Ejecutar siempre</span>
                            </label>
                        </div>

                        {{-- Script para desactivar input --}}
                        <script>
                            document.getElementById('execute_always').addEventListener('change', function () {
                                document.getElementById('time_program').disabled = this.checked;
                            });
                        </script>

                    {{-- Botón --}}
                    <div class="text-right mt-6">
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
                            Guardar
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
