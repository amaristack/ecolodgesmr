<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserRegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store()
    {
        $validate = request()->validate([
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'birth_date' => 'required',
            'age' => 'required',
            'phone_number' => 'required|numeric',
            'email' => 'required',
            'password' => 'required|confirmed',
            'g-recaptcha-response' => 'required|recaptcha'
        ]);

        User::create($validate);

        return redirect('/login')->with('success', 'Registration Successful!');
    }
}
