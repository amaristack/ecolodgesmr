<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store()
    {
        $validate = request()->validate([
            'email' => 'required',
            'password' => 'required'
        ]);


        $remember = request()->has('remember');


        if (!Auth::attempt($validate, $remember)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        request()->session()->regenerate();


        return redirect('/dashboard');
    }

    public function destroy()
    {
        Auth::logout();
        return redirect('/');
    }
}
