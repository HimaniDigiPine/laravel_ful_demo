<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

 use Auth;

class CustomAuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Store user data in session
            session(['user' => $user]);
            return redirect()->route('user.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    // Handle logout
    public function logout()
    {
        session()->forget('user');
        return redirect()->route('user.login.form');
    }


    public function showRegisterForm()
    {
        return view('frontend.auth.register');
    }

    // Handle Registration
    public function register(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'phonenumber' => 'required|string|max:15|unique:users,phonenumber',
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name'        => $request->firstname . ' ' . $request->lastname,
            'phonenumber' => $request->phonenumber,
        ]);

        Auth::login($user);

        return redirect('/userlogin')->with('success', 'Registration successful.');
    }

    // Dashboard
    public function dashboard()
    {
        return view('user.dashboard');
    }
}