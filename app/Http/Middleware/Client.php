<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Client
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated as client
        if (!Auth::guard('client')->check()) {
            // If not authenticated, redirect to the admin login page
            return redirect()->route('client.login')->with('error', 'You must be logged in to access this page.');
        }

        return $next($request);
    }
}
