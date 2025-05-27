<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Record;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->devices();

    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
            ->orWhere('type', 'like', "%{$search}%")
            ->orWhere('id', $search); // permite búsqueda por ID exacto
        });
    }
    
        $devices = $query->paginate(10);
    
        return view('devices.index', compact('devices'));
    }

    public function create()
    {
        return view('devices.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|string|max:100',
            'location' => 'nullable|string|max:100',
            'protocol' => 'nullable|string|max:100',
        ]);

        $device = auth()->user()->devices()->create([
            'name' => $request->name,
            'type' => $request->type,
            'location' => $request->location,
            'protocol' => $request->protocol,
            'status' => 'activo',
        ]);
        
        // 🔵 Registrar en historial
        Record::create([
            'event' => 'Dispositivo creado',
            'description' => 'Dispositivo "' . $device->name . '" creado exitosamente.',
            'date_event' => now(),
            'users_id' => auth()->id(),
        ]);

        return redirect()->route('devices.index')->with('status', 'Dispositivo creado con éxito.');
    }
    public function toggle($id)
    {
        $device = auth()->user()->devices()->findOrFail($id);
        $device->status = $device->status === 'activo' ? 'inactivo' : 'activo';
        $device->save();

            // 🔵 Registrar en Historial
            Record::create([
                'event' => 'Cambio de estado de dispositivo',
                'description' => 'El dispositivo "' . $device->name . '" se marcó como ' . $device->status,
                'date_event' => now(),
                'users_id' => auth()->id(),
            ]);

        return redirect()->route('devices.index')->with('status', 'Estado del dispositivo actualizado.');
    }

    public function edit($id)
    {
        $device = auth()->user()->devices()->findOrFail($id);
        return view('devices.edit', compact('device'));
    }

    public function update(Request $request, $id)
    {
        $device = auth()->user()->devices()->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'location' => 'nullable|string|max:100',
        ]);

        $device->update($request->only('name', 'location'));

        $deviceName = $device->name;
        // 🔵 Registrar en historial actualizacion
        Record::create([
            'event' => 'Dispositivo actualizado',
            'description' => 'Se actualizó el dispositivo "' . $deviceName . '".',
            'date_event' => now(),
            'users_id' => auth()->id(),
        ]);

        return redirect()->route('devices.index')->with('status', 'Dispositivo actualizado.');
    }
    public function destroy($id)
    {
        $device = auth()->user()->devices()->findOrFail($id);
                // Antes de eliminar, guarda el nombre
        $deviceName = $device->name;
        $device->delete();

        // 🔵 Registrar en historial
        Record::create([
            'event' => 'Dispositivo eliminado',
            'description' => 'Se eliminó el dispositivo "' . $deviceName . '".',
            'date_event' => now(),
            'users_id' => auth()->id(),
        ]);

        return redirect()->route('devices.index')->with('status', 'Dispositivo eliminado correctamente.');
    }
}
