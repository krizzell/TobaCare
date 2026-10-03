<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->merge(['email' => Str::lower((string) $request->email)]);

        $data = $request->validate([
            'name'     => ['required', 'string', 'min:2', 'max:100'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:72'],
        ]);

        $user = User::create([
            'role_id'       => Role::where('name', 'user')->value('id'),
            'name'          => strip_tags($data['name']),
            'email'         => $data['email'],
            'password_hash' => Hash::make($data['password']),
        ]);

        return response()->json(['user' => $user->load('role')], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::whereRaw('lower(email) = ?', [Str::lower($data['email'])])->first();

        if (! $user || ! $user->is_active || ! Hash::check($data['password'], $user->password_hash)) {
            return response()->json([
                'error' => ['code' => 'INVALID_CREDENTIALS', 'message' => 'Email atau password salah'],
            ], 401);
        }

        $user->forceFill(['last_login_at' => now()])->save();

        return response()->json([
            'token' => $user->createToken('api')->plainTextToken,
            'user'  => $user->load('role'),
        ]);
    }

    public function me(Request $request)
    {
        return response()->json(['user' => $request->user()->load('role')]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}