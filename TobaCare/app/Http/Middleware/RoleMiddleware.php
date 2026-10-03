<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles)
{
    $role = $request->user()?->role?->name;

    if (! $role || ! in_array($role, $roles, true)) {
        return response()->json([
            'error' => ['code' => 'FORBIDDEN', 'message' => 'Anda tidak memiliki akses'],
        ], 403);
    }

    return $next($request);
}
}
