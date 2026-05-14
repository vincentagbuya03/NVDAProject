<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ForcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->force_password_change) {
            // Allow access to the change password form, update endpoint, and logout
            $allowedRoutes = ['password.change', 'password.update', 'logout'];
            $allowedPaths = ['password/change', 'logout'];
            
            $routeName = $request->route()?->getName();
            $path = $request->path();

            if (!in_array($routeName, $allowedRoutes) && !in_array($path, $allowedPaths)) {
                return redirect()->route('password.change');
            }
        }
        
        return $next($request);
    }
}
