<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Record;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_alert',
        'message',
        'level',
        'devices_id',
    ];

    protected static function booted()
    {
        static::created(function ($alert) {
            // Crear un registro en el historial
            Record::create([
                'event' => 'Alerta creada',
                'description' => 'Tipo: ' . $alert->type_alert . ' | Dispositivo ID: ' . $alert->devices_id,
                'date_event' => now(),
                'users_id' => $alert->device->users_id ?? auth()->id(),
            ]);
        });
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'devices_id');
    }
}
