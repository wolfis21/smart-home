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

            // Guardar en la base de datos
            $automation = new Automation();
            $automation->name = 'Automatización desde API';
            $automation->conditions = [
                'sensor' => $validated['sensor'] ?? 'unknown',
                'valor' => $validated['value'] ?? '0',
            ];
            $automation->action = [
                'device_id' => $validated['device_id'],
                'accion' => 'on',
            ];
            $automation->time_program = now();
            // Asignar el ID de usuario directamente como un valor estático para prueba
            $automation->users_id = 1;
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
