<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HasPermissionMd
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permissionNd): Response
    {
        if (Auth::check()) {
            if (Auth::user()->hasPermission($permissionNd)) {
                return $next($request);
            }
        }

        return response("No tienes permisos.", 401);
    }
}
