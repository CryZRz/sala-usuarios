<?php

namespace App\Http\Middleware;

use App\Http\Utils\Interfaces\HasModule;
use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $user = $request->route('user');

        if (Auth::check() && Auth::user()->id === $user->id) {
            return $next($request);
        };

        /*
         * ¡YA LO SE! El mismo IDE me dice que encapsule esto en una funcion para
         * reutilizarlo con el middleware de hasPermission
         * */
        $controller = $request->route()->getController();

        if ($controller instanceof HasModule) {
            $modulo = $controller->hasModule();

            $permissionEntity = Permission::where("name", "$modulo.$permission")->first();
            $permissions = Permission::dependenciesIds($permissionEntity->id);

            if (Auth::user()->hasPermission($permissionEntity) && Auth::user()->hasPermissions($permissions)) {
                return $next($request);
            }
        }else{
            return redirect()->route('home');
        }

        abort(403, "No tienes permisos");
    }
}
