<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        if (! config('services.google.client_id') || ! config('services.google.client_secret')) {
            return redirect('/register?google_error=' . urlencode('Login Google belum dikonfigurasi. Isi GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET di file .env.'));
        }

        $state = Str::random(40);
        Cache::put('google-oauth-state:' . hash('sha256', $state), true, now()->addMinutes(10));

        return Socialite::driver('google')
            ->stateless()
            ->scopes(['openid', 'profile', 'email'])
            ->with(['state' => $state])
            ->redirect();
    }

    public function callback(Request $request)
    {
        $state = (string) $request->query('state');
        $stateKey = 'google-oauth-state:' . hash('sha256', $state);

        if (! $state || ! Cache::pull($stateKey)) {
            return redirect('/register?google_error=' . urlencode('Sesi Google tidak valid atau sudah kedaluwarsa. Silakan coba lagi.'));
        }

        $googleUser = Socialite::driver('google')->stateless()->user();
        abort_unless($googleUser->getId() && $googleUser->getEmail(), 422, 'Akun Google tidak menyediakan identitas yang diperlukan.');

        $roleId = Role::where('name', 'user')->value('id');

        abort_unless($roleId, 500, 'Role user belum dikonfigurasi.');

        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', Str::lower($googleUser->getEmail()))
            ->first();

        if (! $user) {
            $user = User::create([
                'role_id'       => $roleId,
                'name'          => Str::limit(strip_tags($googleUser->getName() ?: $googleUser->getNickname() ?: 'Warga TobaCare'), 100, ''),
                'email'         => Str::lower($googleUser->getEmail()),
                'password_hash' => Hash::make(Str::random(64)),
                'google_id'     => $googleUser->getId(),
                'password_login_enabled' => false,
                'is_active'     => true,
            ]);
        } else {
            abort_unless($user->is_active, 403, 'Akun ini tidak aktif.');
            $user->forceFill(['google_id' => $user->google_id ?: $googleUser->getId()])->save();
        }

        $code = Str::random(64);
        Cache::put('google-auth:' . $code, [
            'token' => $user->createToken('google')->plainTextToken,
            'user'  => $user->load('role'),
        ], now()->addMinutes(2));

        return redirect('/login?google_code=' . urlencode($code));
    }

    public function exchange(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'size:64'],
        ]);

        $key = 'google-auth:' . $data['code'];
        $payload = Cache::pull($key);

        if (! $payload) {
            return response()->json([
                'error' => ['code' => 'INVALID_GOOGLE_CODE', 'message' => 'Sesi Google sudah kedaluwarsa. Silakan coba lagi.'],
            ], 422);
        }

        return response()->json($payload);
    }
}
