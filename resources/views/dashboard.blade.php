<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Panel Principal') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">

        <!-- 🟦 Tarjetas Resumen -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-2 text-gray-800 dark:text-gray-100">Dispositivos Registrados</h3>
                <p class="text-3xl text-blue-600 font-semibold">{{ $totalDispositivos }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-2 text-gray-800 dark:text-gray-100">Consumo Total (kWh)</h3>
                <p class="text-3xl text-green-600 font-semibold">{{ number_format($consumoTotal, 2) }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-2 text-gray-800 dark:text-gray-100">Alertas Activas</h3>
                <p class="text-3xl text-red-600 font-semibold">{{ $alertasActivas }}</p>
            </div>
        </div>

        <!-- 🟦 Gráficas Principales -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6 mt-12">
            <!-- Gráfico Alertas por Día -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Alertas por Día (últimos 7 días)</h3>
                <canvas id="alertsChart" class="w-full h-64"></canvas>
            </div>

            <!-- Gráfico Distribución por Nivel -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Distribución de Alertas por Nivel</h3>
                <canvas id="alertLevelChart" class="w-full h-64"></canvas>
            </div>
        </div>

        <!-- 🟦 Gráfico Distribución por Tipo -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-6 mt-12">
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 text-center">
                    Distribución de Tipos de Alertas
                </h3>
                <div class="flex justify-center">
                    <canvas id="alertTypeChart" width="600" height="400"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- 🧩 Scripts de Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // 📈 Gráfico de barras: Alertas por día
        const alertsCtx = document.getElementById('alertsChart').getContext('2d');
        new Chart(alertsCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($alertsLabels) !!},
                datasets: [{
                    label: 'Alertas',
                    data: {!! json_encode($alertsData) !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { labels: { color: '#ffffff' }}
                },
                scales: {
                    x: { ticks: { color: '#cccccc' } },
                    y: { ticks: { color: '#cccccc' }, beginAtZero: true }
                }
            }
        });

        // 🥧 Gráfico de pastel: Distribución de alertas por nivel
        const levelCtx = document.getElementById('alertLevelChart').getContext('2d');
        new Chart(levelCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($alertLevels->keys()) !!},
                datasets: [{
                    label: 'Alertas por Nivel',
                    data: {!! json_encode($alertLevels->values()) !!},
                    backgroundColor: [
                        'rgba(220, 38, 38, 0.7)',    // rojo
                        'rgba(234, 179, 8, 0.7)',    // amarillo
                        'rgba(34, 197, 94, 0.7)',    // verde
                    ],
                    borderColor: [
                        'rgba(220, 38, 38, 1)',
                        'rgba(234, 179, 8, 1)',
                        'rgba(34, 197, 94, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: { labels: { color: '#ffffff' }}
                },
                onClick: function (evt, elements) {
                    if (elements.length > 0) {
                        const chart = elements[0].element.$context.chart;
                        const index = elements[0].index;
                        const level = chart.data.labels[index];
                        window.location.href = `/alertas?level=${level}`;
                    }
                }
            }
        });

        // 🥧 Gráfico de pastel: Distribución de tipos de alertas
        const alertTypeCtx = document.getElementById('alertTypeChart').getContext('2d');
        new Chart(alertTypeCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($alertTypes->keys()) !!},
                datasets: [{
                    label: 'Tipos de Alertas',
                    data: {!! json_encode($alertTypes->values()) !!},
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(255, 205, 86, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { labels: { color: '#ffffff' }}
                }
            }
        });
    </script>

</x-app-layout>
