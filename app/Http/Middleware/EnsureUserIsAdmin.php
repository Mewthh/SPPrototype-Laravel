<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->guest(route('login'));
        }

        if (! $request->user()->isAdmin()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Admin privileges required.'], 403);
            }

            abort(403, 'Unauthorized. Admin privileges required.');
        }

        return $next($request);
    }
}
