<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class ConsumeController extends Controller
{
    public function show(Request $request, $deviceId)
    {
        $device = auth()->user()->devices()->findOrFail($deviceId);
    
        $query = $device->consumes()->orderBy('measured_at');
    
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('measured_at', [
                $request->start_date,
                $request->end_date
            ]);
        }
    
        $consumos = $query->get();
    
        $labels = $consumos->pluck('measured_at')->map(fn($date) =>
            \Carbon\Carbon::parse($date)->format('H:i')
        );
    
        return view('consumes.show', [
            'device' => $device,
            'labels' => $labels,
            'energyData' => $consumos->pluck('energy_consumption'),
            'voltageData' => $consumos->pluck('voltage'),
            'currentData' => $consumos->pluck('current'),
        ]);
    }

    /* falta agregar el store para crear las alerts por parte de la API  */
    
}
