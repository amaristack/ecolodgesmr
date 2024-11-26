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

    public function store()
    {
        // Validate input
        $validate = request()->validate([
            'email' => 'required|email',
            'password' => 'required|min:6', // Adjust validation rules as needed
        ]);

        // Check if 'remember' input is present in the request
        $remember = request()->has('remember');

        // Retrieve the user by email
        $user = \App\Models\User::where('email', $validate['email'])->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Get the stored hashed password
        $hashedPassword = $user->password;

        // Replace $2a$ with $2y$ if necessary
        if (Str::startsWith($hashedPassword, '$2a$')) {
            $hashedPassword = '$2y$' . substr($hashedPassword, 4);
        }

        // Check if the password is correct
        if (!Hash::check($validate['password'], $hashedPassword)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Optionally, rehash the password and update the stored hash
        if (Hash::needsRehash($hashedPassword)) {
            $user->password = Hash::make($validate['password']);
            $user->save();
        }

        // Log the user in
        Auth::login($user, $remember);

        // Regenerate the session to prevent session fixation attacks
        request()->session()->regenerate();

        // Redirect to the dashboard after successful login
        return redirect('/dashboard');
    }


    public function destroy()
    {
        Auth::logout();
        return redirect('/');
    }
}
