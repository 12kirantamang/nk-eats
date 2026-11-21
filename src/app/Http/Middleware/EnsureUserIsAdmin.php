<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user || !$this->isAdmin($user)) {
            return response()->json(['message' => '管理者権限が必要です。'], 403);
        }

        return $next($request);
    }

    private function isAdmin($user): bool
    {
        if (isset($user->is_admin) && (bool) $user->is_admin) {
            return true;
        }

        $role = $user->role ?? null;

        return in_array($role, ['admin', 'super_admin'], true);
    }
}
