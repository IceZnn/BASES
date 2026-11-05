<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PerfilMiddleware
{
    public function handle(Request $request, Closure $next, ...$perfis): Response
    {
        abort_unless($request->user() && in_array($request->user()->tipo, $perfis, true), 403);
        return $next($request);
    }
}