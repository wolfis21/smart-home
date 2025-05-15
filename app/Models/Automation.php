<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Automation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'conditions',
        'action',
        'time_program',
        'users_id',
    ];

    protected $casts = [
        'conditions' => 'array',
        'action' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
