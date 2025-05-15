<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Graphic extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_graphics',
        'data_json',
        'consumes_id',
    ];

    protected $casts = [
        'data_json' => 'array',
    ];

    public function consume()
    {
        return $this->belongsTo(Consume::class, 'consumes_id');
    }
}
