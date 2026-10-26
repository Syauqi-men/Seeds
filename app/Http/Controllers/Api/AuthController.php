<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Controller autentikasi API (Sanctum) untuk manajemen akses pengguna.
 */
class AuthController extends Controller
{
    // Daftar role yang diizinkan mengakses endpoint API
    public const ALLOWED_ROLES = ['Administrator', 'Petugas Benih'];

    /**
     * Autentikasi pengguna dan terbitkan token akses Bearer.
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email'       => ['required', 'email'],
            'password'    => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah.',
            ], 401);
        }

        if (! $user->hasAnyRole(self::ALLOWED_ROLES)) {
            return response()->json([
                'message' => 'Akun Anda tidak memiliki akses ke API ini. Hanya Administrator dan Petugas Benih.',
            ], 403);
        }

        $token = $user->createToken($credentials['device_name'] ?? 'api-token')->plainTextToken;

        return response()->json([
            'message'    => 'Login berhasil.',
            'token'      => $token,
            'token_type' => 'Bearer',
            'user'       => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames(),
            ],
        ]);
    }

    /**
     * Ambil data profil pengguna yang sedang terautentikasi.
     */
    public function me(Request $request): JsonResponse
    {
        // Ambil instance user dari token request saat ini
        $user = $request->user();

        return response()->json([
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'roles' => $user->getRoleNames(),
        ]);
    }

    /**
     * Cabut (revoke) token akses yang sedang digunakan.
     */
    public function logout(Request $request): JsonResponse
    {
        // Ambil token aktif dari sesi request saat ini
        $token = $request->user()->currentAccessToken();

        // Hapus token dari database jika valid dan mendukung penghapusan
        if ($token && method_exists($token, 'delete')) {
            $token->delete();
        }

        return response()->json(['message' => 'Logout berhasil, token telah dicabut.']);
    }
}