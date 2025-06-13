<?php

namespace App\Http\Controllers;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\WelcomeEmail;
class UserController extends Controller
{
    // Mostra il form di registrazione
    public function showRegistrationForm()
    {
        return view('posts.register');
    }

    // Gestisce la registrazione
    public function register(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'age'=> 'required|integer|min:0|max:100',
        ]);

        $user = User::create([
            'name' => $validateData['name'],
            'email' => $validateData['email'],
            'password' => Hash::make($validateData['password']),
            'age'=> $validateData ['age'],
        ]);
        Mail::to($user->email)->send(new WelcomeEmail($user)); // Usa $user->email, NON $user->mail
        event(new UserRegistered($user));

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registrazione completata!');
    }

    // Mostra il form di login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Gestisce il login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Login effettuato con successo!');

        }

        return back()->withErrors([
            'email' => 'Le credenziali fornite non sono corrette.',
        ])->onlyInput('email');
    }

    // Gestisce il logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logout effettuato con successo!');
    }
}
