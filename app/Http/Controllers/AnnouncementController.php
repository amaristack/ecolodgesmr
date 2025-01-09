<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of announcements.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all announcements ordered by date_posted descending
        $announcements = Announcement::orderBy('date_posted', 'desc')->get();

        return view('user.user_announcement', compact('announcements'));
    }
}
