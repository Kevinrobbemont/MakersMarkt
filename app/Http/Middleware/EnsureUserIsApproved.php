<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsApproved
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && !$user->isApproved()) {
            // Allow admins and moderators to bypass the approval check
            if ($user->isAdminOrModerator()) {
                return $next($request);
            }

            return redirect('/dashboard')->with('warning', 'Je account moet nog door een moderator worden goedgekeurd voordat je volledig gebruik kunt maken van het platform. Controleer je e-mail voor updates.');
        }

        return $next($request);
    }
}
