<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and is an admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            // If not, return a 403 Forbidden response
            return response()->simpleError(__('app.forbidden_access'), Response::HTTP_FORBIDDEN);
        }

        // If the user is an admin, proceed with the request
        return $next($request);
    }
}
