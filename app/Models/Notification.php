<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'icon',
        'color',
        'link',
        'is_read',
        'is_admin'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'is_admin' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 