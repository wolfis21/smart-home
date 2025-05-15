<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alert;
use App\Models\Record;

class AlertController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $devices = $user->devices()->orderBy('name')->get();
    
        $alertsQuery = Alert::whereHas('device', function($query) use ($user) {
            $query->where('users_id', $user->id);
        })->with('device');
    
        if ($request->filled('device_id')) {
            $alertsQuery->where('devices_id', $request->device_id);
        }
        if (request()->filled('level')) {
            $alertsQuery->where('level', request('level'));
        }
    
        $alerts = $alertsQuery->latest()->paginate(10)->withQueryString();
    
        return view('alerts.index', compact('alerts', 'devices'));
    }

    /* falta agregar el store para crear las alerts por parte de la API  */

    public function clear(Request $request)
    {
        $user = auth()->user();

        $query = Alert::whereHas('device', function($q) use ($user) {
            $q->where('users_id', $user->id);
        });

        if ($request->filled('device_id')) {
            $query->where('devices_id', $request->device_id);
        }

        $count = $query->count();
        $query->delete();

        if ($count > 0) {
            Record::create([
                'event' => 'Limpieza de alertas',
                'description' => 'Se eliminaron ' . $count . ' alertas',
                'date_event' => now(),
                'users_id' => auth()->id(),
            ]);
        }

        return redirect()->route('alerts.index')->with('status', "$count alertas eliminadas correctamente.");
    }
}
