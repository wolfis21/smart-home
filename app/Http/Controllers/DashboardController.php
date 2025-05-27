<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Device;
use App\Models\Consume;
use App\Models\Alert;
use App\Models\Record;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $totalDispositivos = $user->devices()->count();
        $consumoTotal = $user->devices()
                             ->with('consumes')
                             ->get()
                             ->pluck('consumes')
                             ->flatten()
                             ->sum('energy_consumption');
        $alertasActivas = $user->devices()
                               ->withCount('alerts')
                               ->get()
                               ->sum('alerts_count');

        // 🔥 Consultar cantidad de alertas por fecha (últimos 7 días)
        $alertsByDate = DB::table('alerts')
            ->join('devices', 'alerts.devices_id', '=', 'devices.id')
            ->where('devices.users_id', $user->id)
            ->whereDate('alerts.created_at', '>=', now()->subDays(7))
            ->select(DB::raw('DATE(alerts.created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $alertsLabels = $alertsByDate->pluck('date');
        $alertsData = $alertsByDate->pluck('total');

        $alertLevels = DB::table('alerts')
            ->join('devices', 'alerts.devices_id', '=', 'devices.id')
            ->where('devices.users_id', auth()->id())
            ->select('level', DB::raw('COUNT(*) as total'))
            ->groupBy('level')
            ->pluck('total', 'level');

            if ($request->filled('level')) {
                $alertsQuery->where('level', $request->level);
            }
        
        $alertTypes = DB::table('alerts')
            ->join('devices', 'alerts.devices_id', '=', 'devices.id')
            ->where('devices.users_id', auth()->id())
            ->select('type_alert', DB::raw('COUNT(*) as total'))
            ->groupBy('type_alert')
            ->pluck('total', 'type_alert');

            // 🔔 Últimas 3 notificaciones útiles
        $notificaciones = Record::where('users_id', $user->id)
            ->whereNotIn('event', ['Mensaje MQTTss', 'Automatización creada', 'Inicio de sesión'])
            ->orderByDesc('date_event')
            ->limit(3)
            ->get();

        return view('dashboard', compact(
            'totalDispositivos',
            'consumoTotal',
            'alertasActivas',
            'alertsLabels',
            'alertsData',
            'alertLevels',
            'alertTypes',
            'notificaciones' // evaluar
        ));
    }
}
