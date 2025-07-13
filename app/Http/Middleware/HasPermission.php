<?php

namespace App\Http\Middleware;

use App\Http\Utils\Interfaces\HasModule;
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

                if (Auth::user()->hasPermission("$modulo.$permission")) {
                    return $next($request);
                }
            }else{
                //SE SUPONE QUE HA ETSE LUGAR NUNCA DEBERIAMOS DE LLEGAR!!!
                return redirect()->route('home');
            }
        }

        return response("No tienes permisos.", 401);
    }
}
