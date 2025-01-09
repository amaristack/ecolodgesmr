<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'user_id',
        'room_id',
        'pool_id',
        'activity_id',
        'hall_id',
        'total_amount',      // Added: Total booking amount
        'amount_paid',       // Added: Amount paid (downpayment)
        'balance_due',       // Added: Remaining balance
        'payment_amount',    // Existing: Payment amount (downpayment in this case)
        'payment_method',
        'payment_status',    // Added: 'Partial', 'Paid', etc.
        'booking_status',    // Added: 'Pending', 'Confirmed', etc.
        'check_in',
        'check_out',
        'note',
        'paymongo_link_id',
        'decline_reason',
        'number_of_person',
        'guest_names',// Added: Additional notes
        // Remove 'status' if it's replaced by 'payment_status' and 'booking_status'
    ];

    protected $casts = [
        'guest_names' => 'array',  // Ensure this is an array
        'check_in' => 'datetime',  // Ensure this is a DateTime instance
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }

    public function pool(): BelongsTo
    {
        return $this->belongsTo(Pool::class, 'pool_id', 'pool_id');
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'activity_id');
    }

    public function hall(): BelongsTo
    {
        return $this->belongsTo(Hall::class, 'hall_id', 'hall_id');
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class, 'booking_id');
    }
}
