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

        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Email atau password salah',
            ], 401);
        }

        $user  = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'  => 'success',
            'message' => 'Login berhasil',
            'user'    => $user,
            'token'   => $token,
        ]);
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

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'  => 'success',
            'message' => 'Registrasi berhasil',
            'user'    => $user,
            'token'   => $token,
        ], 201);
    }

    public function google_redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function google_callback()
    {
        try {
            // Ambil data user dari Google
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cari user di database, buat baru kalau belum ada
            $user = User::firstOrCreate(
                ['email' => $googleUser->email],
                [
                    'name'     => $googleUser->name,
                    'password' => bcrypt(\Illuminate\Support\Str::random(16)),
                    'status'   => 'active',
                    'role'     => 'customer',
                ]
            );

            // Cek status banned
            if ($user->status === 'banned') {
                return redirect("http://localhost:5173/login?error=account_banned");
            }

            // Buat token API
            $token = $user->createToken('auth_token')->plainTextToken;

            // Redirect ke frontend dengan token
            return redirect("http://localhost:5173/login-success?token={$token}");

        } catch (\Exception $e) {
            // Kalau ada error redirect ke login dengan pesan error
            return redirect("http://localhost:5173/login?error=google_error");
        }
    }

    public function logout(Request $request)
    {
        if (! $request->user()) {
            return response()->json([
                'status'  => false,
                'message' => 'User not authenticated',
            ], 401);
        }

        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status'  => true,
            'message' => 'Logout berhasil',
        ]);
    }
}
