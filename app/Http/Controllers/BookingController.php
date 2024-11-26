<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Booking;
use App\Models\Feedback;
use App\Models\Hall;
use App\Models\Pool;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index()
    {
        return view('check_availabilty');
    }

    public function showAll()
    {
        // Fetch records with no null values based on earlier requirements
        $rooms = Room::whereNotNull('room_type')->get();
        $activities = Activity::all(); // Assuming no null filtering is needed for activities
        $cottages = Pool::whereNotNull('cottage_type')->get();
        $halls = Hall::whereNotNull('hall_name')->get();

        return view('user.book', compact('rooms', 'activities', 'cottages', 'halls'));
    }


    public function viewDetailedBooking($id)
    {
        $booking = Booking::findOrFail($id);

        $feedbackExists = Feedback::where('booking_id', $booking->booking_id)->exists();

        return view('user.user_booking_info', compact('booking', 'feedbackExists'));
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

    public function submitFeedback(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,booking_id',
            'rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:1000',
        ]);

        Feedback::create([
            'booking_id' => $request->input('booking_id'),
            'rating' => $request->input('rating'),
            'comments' => $request->input('comments'),
        ]);

        return redirect()->route('viewDetailed.booking', $request->input('booking_id'))->with('success', 'Thank you for your feedback!');
    }
}
