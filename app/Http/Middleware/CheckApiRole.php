<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;
use App\Models\User;

class CheckApiRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $userRoll = Role::where('role_type', $role)->firstOrFail();
        if (!auth()->check() || $request->user()->role_id !== $userRoll->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
