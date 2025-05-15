<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consume extends Model
{
    use HasFactory;

    protected $fillable = [
        'measured_at',
        'energy_consumption',
        'voltage',
        'current',
        'devices_id',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'devices_id');
    }

    public function graphics()
    {
        return $this->hasMany(Graphic::class, 'consumes_id');
    }
}
