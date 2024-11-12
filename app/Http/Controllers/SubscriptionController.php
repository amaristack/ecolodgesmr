<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        Mail::to($request->email)->send(new NewsletterSubscription($request->email));

        return back()->with('success', 'Thank you for subscribing!');
    }
}
