<?php

namespace App\Http\Middleware;

use App\Http\Utils\Interfaces\HasModule;
use App\Models\AppModule;
use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $controller = $request->route()->getController();

            if ($controller instanceof HasModule) {
                $modulo = $controller->hasModule();

                $permissionEntity = AppModule::where("name", "=", $modulo)->first();

                if ($permissionEntity->is_active) {
                    return $next($request);
                }
            }else{
                //SE SUPONE QUE HA ETSE LUGAR NUNCA DEBERIAMOS DE LLEGAR!!!
                return redirect()->route('home');
            }
        }

        return redirect()->route('notModule');
    }
}
