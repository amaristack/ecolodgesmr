<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $bookings = Booking::with(['room', 'activity', 'user', 'hall']) // Eager load the relationships
        ->where('user_id', auth()->id())
            ->get();

        $user = auth()->user(); // Get the authenticated user
        return view('user.user_notifications', ['bookings' => $bookings, 'user' => $user]);
    }
}
