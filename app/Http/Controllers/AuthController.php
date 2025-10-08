<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|max:50',
            'password' => 'required|max:50',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            if (Auth::user()->role == 'customer') {
                return redirect('/home');
            }

            return redirect('/dashboard');
        }

        return back()->with('failed', 'Email atau password salah');
    }

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

    public function google_redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function google_callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $googleUser->email)->first();

        if (! $user) {
            $user = User::create([
                'name'     => $googleUser->name,
                'email'    => $googleUser->email,
                'password' => bcrypt(\Illuminate\Support\Str::random(16)),
                'status'   => 'active',
                'role'     => 'customer',
            ]);
        }

        if ($user->status === 'banned') {
            return redirect('/login')->with('failed', 'Akun anda telah dibekukan');
        }

        Auth::login($user);
        return redirect('/home');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
