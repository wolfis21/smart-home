<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Consumo energético - {{ $device->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">

        {{-- 🔵 Filtros de fecha --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" class="bg-white dark:bg-gray-800 p-6 rounded shadow grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-1">Desde</label>
                    <input type="datetime-local" name="start_date" value="{{ request('start_date') }}"
                        class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600">
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-1">Hasta</label>
                    <input type="datetime-local" name="end_date" value="{{ request('end_date') }}"
                        class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600">
                </div>
            <div class="flex flex-col md:flex-row items-stretch md:items-end gap-2 w-full">
                <button type="submit"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                    Filtrar
                </button>

                <a href="{{ route('consumes.show', $device->id) }}"
                    class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded text-center">
                    Resetear
                </a>
            </div>
            </form>
        </div>

        {{-- 🔵 Gráficas --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6 mt-12">

            {{-- Gráfico de Consumo --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 text-center">Consumo (kWh)</h3>
                <div class="h-64">
                    <canvas id="energyChart" class="w-full h-full"></canvas>
                </div>
            </div>

            {{-- Gráfico de Voltaje --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 text-center">Voltaje (V)</h3>
                <div class="h-64">
                    <canvas id="voltageChart" class="w-full h-full"></canvas>
                </div>
            </div>

            {{-- Gráfico de Corriente --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 text-center">Corriente (A)</h3>
                <div class="h-64">
                    <canvas id="currentChart" class="w-full h-full"></canvas>
                </div>
            </div>

        </div>

    </div>

    {{-- 🔵 Script de Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = {!! json_encode($labels) !!};

        function createChart(id, label, data, color) {
            return new Chart(document.getElementById(id).getContext('2d'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        borderColor: color,
                        fill: false,
                        tension: 0.3,
                        pointBackgroundColor: color,
                        pointBorderColor: color,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#ffffff'
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: '#cccccc' }
                        },
                        y: {
                            ticks: { color: '#cccccc' }
                        }
                    }
                }
            });
        }

        createChart('energyChart', 'Consumo (kWh)', {!! json_encode($energyData) !!}, 'rgb(75, 192, 192)');
        createChart('voltageChart', 'Voltaje (V)', {!! json_encode($voltageData) !!}, 'rgb(255, 205, 86)');
        createChart('currentChart', 'Corriente (A)', {!! json_encode($currentData) !!}, 'rgb(255, 99, 132)');
    </script>
</x-app-layout>
