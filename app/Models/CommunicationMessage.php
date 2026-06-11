<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunicationMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'body',
        'sender',
        'recipient',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}

