<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_name',
        'message',
        'date_posted',
    ];

    // Use casts instead of dates for better flexibility
    protected $casts = [
        'date_posted' => 'datetime',
    ];
}
