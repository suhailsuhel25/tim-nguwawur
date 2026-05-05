<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah.',
            ], 401);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Eager load relasi spesifik berdasarkan role untuk data kembalian
        if ($user->role === 'student') {
            $user->load('student');
        } elseif ($user->role === 'lecturer') {
            $user->load('lecturer');
        }

        // Generate Sanctum token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => $user,
                'token' => $token,
                'role' => $user->role,
            ]
        ], 200);
    }

    /**
     * Get the authenticated user.
     */
    public function me(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        
        if ($user->role === 'student') {
            $user->load('student');
        } elseif ($user->role === 'lecturer') {
            $user->load('lecturer');
        }

        return response()->json([
            'success' => true,
            'data' => clone $user,
        ]);
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        // Revoke the token that was used to authenticate the current request
        /** @var \Laravel\Sanctum\PersonalAccessToken $token */
        $token = $user->currentAccessToken();
        $token->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil. Token dihapus.',
        ]);
    }
}
