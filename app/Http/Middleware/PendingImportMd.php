<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use \App\Models\PendingImport;

class PendingImportMd
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $importPending = PendingImport::getLast();

        if ($importPending?->is_pending){
            return redirect()->route("import.showPending", $importPending?->id);
        }

        return $next($request);
    }
}
