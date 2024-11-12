<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hall extends Model
{
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
