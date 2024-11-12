<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserDashboardController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        $activities = Activity::all(); // Fetch activities data as well
        return view('user.user-welcome', ['rooms' => $rooms, 'activities' => $activities]);
    }


    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.user_dashboard', ['user' => $user]);
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.user_profile_settings' , ['user' => $user]);
    }


    public function update($id)
    {
        request()->validate([
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'first_name' => request('first_name'),
            'middle_name' => request('middle_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
            'phone_number' => request('phone_number'),
            'address' => request('address'),
        ]);

        return redirect('/user/' . $user->id . '/edit')->with('success', 'Profile updated successfully');
    }

    public function ChangePassword($id)
    {
        $user = User::findOrFail($id);
        return view('user.user_change_password' , ['user' => $user]);
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();


        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }

    public function ViewBooking()
    {
        // Fetch bookings for the authenticated user, with pagination
        $bookings = Booking::where('user_id', auth()->id()) // Only show bookings for the logged-in user
        ->orderBy('created_at', 'desc') // Optionally, order by the latest bookings
        ->paginate(5); // Paginate the results with 10 per page

        // Pass the bookings to the view
        return view('user.user_booking', ['bookings' => $bookings]);
    }
}
