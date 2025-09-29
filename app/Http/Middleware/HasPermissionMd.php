<?php

namespace App\Http\Middleware;

use App\Models\Permission;
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
            $permission = Permission::where("name", $permissionNd)->first();
            $dependencies = $permission->getWithDependenciesIds();

            if (Auth::user()->hasPermission($permission) && Auth::user()->hasPermissions($dependencies)) {
                return $next($request);
            }
        }

        return response("No tienes permisos.", 401);
    }
}
