<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Automation;

class DeviceDataController extends Controller
{
    public function receiveData(Request $request)
    {
        try {
            $validated = $request->validate([
                'device_id' => 'required|string',
                'sensor' => 'nullable|string',
                'value' => 'nullable|string',
                'timestamp' => 'nullable|date',
            ]);
    
            // Guardar los datos en la base de datos
            $automation = new Automation();
            $automation->name = 'Automatización desde API';
            $automation->conditions = json_encode([
                'sensor' => $validated['sensor'] ?? 'unknown',
                'valor' => $validated['value'] ?? '0',
            ]);
            $automation->action = json_encode([
                'device_id' => $validated['device_id'],
                'accion' => 'on',
            ]);
            $automation->time_program = now();
            $automation->users_id = auth()->id();
            $automation->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Datos recibidos correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    
}
