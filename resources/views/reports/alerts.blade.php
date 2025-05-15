<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Alertas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }
        th, td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            color: white;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-alto {
            background-color: #e3342f;
        }
        .badge-medio {
            background-color: #f6993f;
        }
        .badge-bajo {
            background-color: #38c172;
        }
    </style>
</head>
<body>
    <h2>Reporte de Alertas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Dispositivo</th>
                <th>Tipo de Alerta</th>
                <th>Mensaje</th>
                <th>Nivel</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alerts as $alert)
                <tr>
                    <td>{{ $alert->id }}</td>
                    <td>{{ $alert->device->name ?? 'Sin dispositivo' }}</td>
                    <td>{{ ucfirst($alert->type_alert) }}</td>
                    <td>{{ $alert->message }}</td>
                    <td>
                        <span class="badge 
                            @if($alert->level === 'alto') badge-alto
                            @elseif($alert->level === 'medio') badge-medio
                            @else badge-bajo
                            @endif">
                            {{ ucfirst($alert->level) }}
                        </span>
                    </td>
                    <td>{{ $alert->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
