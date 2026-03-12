<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsBuyer
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $roleName = $user?->role?->name;

        if (!$user || !$user->role) {
            abort(403, 'Je moet ingelogd zijn om te kunnen bestellen.');
        }

        // Buyers are users who are NOT makers and NOT admins
        if (in_array($roleName, ['maker', 'admin', 'moderator'], true)) {
            abort(403, 'Makers en admins kunnen niet als koper bestellen.');
        }

        return $next($request);
    }
}
