<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\PersonalAccessToken;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Login API
     * POST /api/login
     */
    public function login(Request $request)
    {
        // Validasi input
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        // Cek user
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.'
            ], 401);
        }

        // Generate token baru
        $plainTextToken = hash('sha256', Str::random(64));

        // Simpan ke tabel personal_access_tokens
        PersonalAccessToken::create([
            'tokenable_type' => User::class,
            'tokenable_id' => $user->id,
            'name' => $user->name,
            'token' => $plainTextToken,
            'abilities' => json_encode(['*']),
            'last_used_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addDays(7), // Token aktif 7 hari
        ]);

        // Response sukses
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_type' => $user->user_type,
                ],
                'token' => $plainTextToken
            ]
        ]);
    }

    /**
     * Logout API
     * POST /api/logout
     */
    public function logout(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['success' => false, 'message' => 'Token tidak ditemukan.'], 401);
        }

        $deleted = PersonalAccessToken::where('token', $token)->delete();

        return response()->json([
            'success' => $deleted > 0,
            'message' => $deleted ? 'Logout berhasil.' : 'Token tidak valid.'
        ]);
    }

    /**
     * Endpoint untuk mengecek user login
     * GET /api/me
     */
    public function me(Request $request)
    {
        $token = $request->bearerToken();

        $personalToken = PersonalAccessToken::where('token', $token)->first();

        if (!$personalToken) {
            return response()->json(['success' => false, 'message' => 'Token tidak valid.'], 401);
        }

        // Ambil data user utama
        $user = User::find($personalToken->tokenable_id);

        // Ambil data tambahan dari users_information
        $user_information = DB::table('users_information')
            ->where('user_id', $user->id)
            ->first();

        // Gabungkan keduanya dalam response
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'user_type' => $user->user_type,
                'user_status' => $user->user_status,
                'information' => $user_information
            ]
        ]);
    }

}
