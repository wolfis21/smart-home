<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'status',
        'protocol',
        'location',
        'users_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function consumes()
    {
        return $this->hasMany(Consume::class, 'devices_id');
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class, 'devices_id');
    }
}
