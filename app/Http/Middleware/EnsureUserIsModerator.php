<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsModerator
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $roleName = $user?->role?->name;

        if (! $user || ! $user->role || ! in_array($roleName, ['moderator', 'admin'])) {
            abort(403, 'Alleen moderators en admins hebben toegang tot deze pagina.');
        }

        return $next($request);
    }
}
