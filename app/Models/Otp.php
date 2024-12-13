<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $table = "otp_table";

    protected $guarded = [];

    protected $casts = [
        'expires_at' => 'datetime',
        'otp' => 'integer',
    ];
}
