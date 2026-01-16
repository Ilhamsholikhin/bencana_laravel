<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisasterReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'location',
        'occurred_at',
        'severity',
        'status',
        'description',
        'casualties',
        'source_url',
    ];

    protected $casts = [
        'occurred_at' => 'datetime',
        'severity'    => 'integer',
        'casualties'  => 'integer',
    ];
}
