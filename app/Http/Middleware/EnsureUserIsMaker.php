<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsMaker
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $roleName = $user?->role?->name;

        if (! $user || ! $user->role || ! in_array($roleName, ['maker', 'admin'])) {
            abort(403, 'Alleen makers en admins mogen producten beheren.');
        }

        return $next($request);
    }
}
