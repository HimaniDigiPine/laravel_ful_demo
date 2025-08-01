<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow register and login routes
        
        if (Auth::check() && Auth::user()->email === 'himani@digipineinfotech.com') {
            return $next($request);
        }

        return redirect('/middlewareCheck')->with('error', 'Unauthorized access.');
    }
}
