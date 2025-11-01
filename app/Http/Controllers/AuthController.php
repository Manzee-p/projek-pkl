<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * 🔐 Login Manual
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|max:50',
            'password' => 'required|max:50',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors(['login' => 'Email atau password salah']);
        }

        $user = Auth::user();

        // ✅ Jika admin → home
        if ($user->role === 'admin') {
            return redirect('/home');
        }

        // ✅ Jika user customer → home juga
        return redirect('/home');
    }

    /**
     * 🧾 Registrasi manual
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|max:50',
            'email'    => 'required|email|max:50|unique:users',
            'password' => 'required|max:50|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'status'   => 'active',
            'role'     => 'customer',
        ]);

        Auth::login($user);

        return redirect('/home');
    }

    /**
     * 🌐 Login Google
     */
    public function google_redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function google_callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::firstOrCreate(
                ['email' => $googleUser->email],
                [
                    'name'     => $googleUser->name,
                    'password' => bcrypt(Str::random(16)),
                    'status'   => 'active',
                    'role'     => 'customer',
                ]
            );

            Auth::login($user);

            // ✅ User Google masuk ke welcome.blade.php
            return redirect('/welcome');

        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['google' => 'Google login gagal']);
        }
    }

    /**
     * 🚪 Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
