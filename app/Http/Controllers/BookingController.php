<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Booking;
use App\Models\Hall;
use App\Models\Pool;
use App\Models\Room;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('check_availabilty');
    }

    public function showAll()
    {
        $rooms = Room::all();
        $activities = Activity::all();
        $cottages = Pool::all();
        $halls = Hall::all();

        return view('user.book', compact('rooms', 'activities', 'cottages', 'halls'));
    }

    public function viewDetailedBooking($id)
    {
        $booking = Booking::findOrFail($id);
        return view('user.user_booking_info', compact('booking'));
    }

    public function cancelBooking(Request $request, $booking_id)
    {
        $booking = Booking::findOrFail($booking_id);

        // Update the payment_status and booking_status to "Cancelled"
        $booking->payment_status = 'Cancelled';
        $booking->booking_status = 'Cancelled';
        $booking->save();

        return redirect()->route('view.booking')->with('success', 'Booking has been cancelled.');
    }

    public function checkAvailability(Request $request)
    {
        $category = $request->input('category');

        // Retrieve items based on selected category, only if availability is greater than zero
        if ($category === 'rooms') {
            $items = Room::where('availability', '>', 0)->get();
        } elseif ($category === 'activity') {
            $items = Activity::where('availability', '>', 0)->get();
        } elseif ($category === 'cottages') {
            $items = Pool::where('availability', '>', 0)->get();
        } elseif ($category === 'function_hall') {
            $items = Hall::where('availability', '>', 0)->get();
        } else {
            $items = collect(); // Empty collection if no matching category
        }

        // Pass the available items to the view with the selected category
        return view('user.user_availability', compact('items', 'category'));
    }

}
