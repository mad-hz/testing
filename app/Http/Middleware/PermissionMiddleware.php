<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = null, $permission = null): Response
    {
        if ($role && !$permission && $request->user()->can($role)) {
            return $next($request);
        }

        if ($role && !$request->user()->hasRole($role)) {
            return response()->view('errors.403', [], 403);
        }

        if ($permission && !$request->user()->can($permission)) {
            return response()->view('errors.403', [], 403);
        }

        return $next($request);
    }
}
