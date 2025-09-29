<?php

namespace App\Http\Middleware;

use App\Http\Utils\Interfaces\HasModule;
use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        if (Auth::check()) {
            $controller = $request->route()->getController();

            if ($controller instanceof HasModule) {
                $modulo = $controller->hasModule();

                $permissionEntity = Permission::where("name", "$modulo.$permission")->first();
                $permissions = Permission::dependenciesIds($permissionEntity->id);

                if (Auth::user()->hasPermission($permissionEntity) && Auth::user()->hasPermissions($permissions)) {
                    return $next($request);
                }
            }else{
                //SE SUPONE QUE HA ETSE LUGAR NUNCA DEBERIAMOS DE LLEGAR!!!
                return redirect()->route('home');
            }
        }

        // Aquí decides según el tipo de petición
        if ($request->expectsJson() || $request->is('api/*')) {
            // Petición desde API → devolver JSON con 403
            return response()->json(['message' => 'No tienes permisos'], 403);
        }

        // Petición normal → redirigir o mostrar vista
        return redirect()->route('notPermissions');
    }
}
