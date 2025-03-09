<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();

            // Check if there's an intended checkout
            if ($intended = session('intended_checkout')) {
                session()->forget('intended_checkout');
                // Make sure we're using the correct route parameters
                return redirect()->route('checkout', [
                    'type' => strtolower($intended['type']), // ensure lowercase
                    'id' => $intended['id']
                ]);
            }

            return redirect('/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }

    public function destroy()
    {
        Auth::logout();
        return redirect('/');
    }
}
