<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = \App\Models\User::where('email', strtolower($credentials['email']))->first();

        if (!$user || !Hash::check($credentials['password'], $user->password) || !$this->isAdmin($user)) {
            throw ValidationException::withMessages([
                'email' => ['管理者メールアドレスまたはパスワードが正しくありません。'],
            ]);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }

    public function user(Request $request)
    {
        $user = $request->user();

        if (!$user || !$this->isAdmin($user)) {
            return response()->json(['authenticated' => false], 401);
        }

        return response()->json([
            'authenticated' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'ログアウトしました']);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'admin_key' => ['required', 'string'],
        ]);

        $registrationKey = (string) env('ADMIN_REGISTRATION_KEY', 'FOODIEX2026');
        if (!hash_equals($registrationKey, $validated['admin_key'])) {
            throw ValidationException::withMessages([
                'admin_key' => ['The admin setup key is invalid.'],
            ]);
        }

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
            'is_admin' => true,
            'role' => 'admin',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ], 201);
    }

    private function isAdmin($user): bool
    {
        return (bool) ($user->is_admin ?? false) || in_array($user->role ?? '', ['admin', 'super_admin'], true);
    }
}
