<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $bookings = Booking::with(['room', 'activity', 'user', 'hall'])
        ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(5); 

        $user = auth()->user(); // Get the authenticated user
        return view('user.user_notifications', ['bookings' => $bookings, 'user' => $user]);
    }

}
