<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Automation;
use App\Models\Device;

class AutomationController extends Controller
{
    /**
     * Mostrar listado de automatizaciones del usuario.
     */
    public function index()
{
    $automations = Automation::where('users_id', auth()->id())
                    ->orderBy('created_at', 'desc')
                    ->paginate(10) // Cambiado de get() a paginate(10)
                    ->through(function ($automation) {
                        $conditions = json_decode($automation->conditions, true);
                        $action = json_decode($automation->action, true);

                        // Formatear Condiciones
                        $formattedConditions = [];
                        foreach ($conditions as $key => $value) {
                            if ($key === 'sensor') {
                                $formattedConditions[] = 'Sensor: ' . ucfirst($value);
                            } elseif ($key === 'hora') {
                                $formattedConditions[] = 'Hora: ' . $value;
                            } elseif ($key === 'valor') {
                                $formattedConditions[] = 'Valor: ' . $value;
                            } elseif ($key === 'operador') {
                                $formattedConditions[] = 'Operador: ' . $value;
                            }
                        }

                        // Formatear Acciones
                        $formattedAction = [];
                        if (isset($action['device_id'])) {
                            $deviceName = 'Dispositivo ' . $action['device_id'];
                            $formattedAction[] = 'Dispositivo: ' . $deviceName;
                        }
                        if (isset($action['accion'])) {
                            $formattedAction[] = 'Acción: ' . ($action['accion'] === 'on' ? 'Encender' : 'Apagar');
                        }

                        $automation->formatted_conditions = $formattedConditions;
                        $automation->formatted_action = $formattedAction;

                        return $automation;
                    });

    return view('automations.index', compact('automations'));
}


    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $devices = Device::where('users_id', auth()->id())->get();

        /* provisional hasta implementar dispositivos especificos para el hogar (NO IMPLEMENTADO ES EJEMPLO) */
        $conditionsByDeviceType = [
            'Aire acondicionado' => ['temperatura', 'estado'],
            'Luces' => ['estado'],
            'Enchufe inteligente' => ['consumo', 'estado'],
        ];
    
        return view('automations.create', compact('devices', 'conditionsByDeviceType'));
    }

    /**
     * Guardar una nueva automatización.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'sensor' => 'required|string',
            'operador' => 'required|string',
            'valor' => 'required',
            'device_id' => 'required|exists:devices,id',
            'accion' => 'required|string|in:on,off',
            'time_program' => 'nullable|date_format:Y-m-d\TH:i',
        ]);
    
        $conditions = [
            'sensor' => $request->sensor,
            'operador' => $request->operador,
            'valor' => $request->valor,
        ];
    
        $action = [
            'device_id' => $request->device_id,
            'accion' => $request->accion,
        ];
    
        $automation = Automation::create([
            'name' => $request->name,
            'conditions' => json_encode($conditions),
            'action' => json_encode($action),
            'time_program' => $request->time_program,
            'users_id' => auth()->id(),
        ]);
    
        // Registro en historial
        \App\Models\Record::create([
            'event' => 'Automatización creada',
            'description' => 'Se creó la automatización "' . $automation->name . '".',
            'date_event' => now(),
            'users_id' => auth()->id(),
        ]);
    
        return redirect()->route('automations.index')->with('status', 'Automatización creada exitosamente.');
    }
    

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Automation $automation)
    {
        $this->authorizeAutomation($automation);
        $devices = Device::where('users_id', auth()->id())->get();

        return view('automations.edit', compact('automation', 'devices'));
    }

    /**
     * Actualizar una automatización.
     */
    public function update(Request $request, Automation $automation)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'sensor' => 'required|string',
            'operador' => 'required|string',
            'valor' => 'required',
            'device_id' => 'required|exists:devices,id',
            'accion' => 'required|string|in:on,off',
            'time_program' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        $conditions = [
            'sensor' => $request->sensor,
            'operador' => $request->operador,
            'valor' => $request->valor,
        ];

        $action = [
            'device_id' => $request->device_id,
            'accion' => $request->accion,
        ];

        $automation->update([
            'name' => $request->name,
            'conditions' => json_encode($conditions),
            'action' => json_encode($action),
            'time_program' => $request->time_program,
        ]);

        // Registro en historial
        \App\Models\Record::create([
            'event' => 'Automatización actualizada',
            'description' => 'Se actualizó la automatización "' . $automation->name . '".',
            'date_event' => now(),
            'users_id' => auth()->id(),
        ]);

        return redirect()->route('automations.index')->with('status', 'Automatización actualizada correctamente.');
    }

    /**
     * Eliminar una automatización.
     */
    public function destroy(Automation $automation)
    {
        // Opcional: verificar que la automatización pertenezca al usuario autenticado
        if ($automation->users_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }
    
        $automation->delete();
    
        // 🔵 Registrar eliminación en historial
        \App\Models\Record::create([
            'event' => 'Automatización eliminada',
            'description' => 'Se eliminó la automatización "' . $automation->name . '".',
            'date_event' => now(),
            'users_id' => auth()->id(),
        ]);
    
        return redirect()->route('automations.index')->with('status', 'Automatización eliminada exitosamente.');
    }
    

    /**
     * Método privado para proteger accesos.
     */
    private function authorizeAutomation(Automation $automation)
    {
        if ($automation->users_id !== auth()->id()) {
            abort(403);
        }
    }
}
