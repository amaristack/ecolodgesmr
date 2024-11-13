<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hall extends Model
{

    protected $table = 'halls';

    protected $primaryKey = "hall_id";

    protected $guarded = [];
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
