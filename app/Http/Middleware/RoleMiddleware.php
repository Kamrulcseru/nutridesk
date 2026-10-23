<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $userRole = $request->user()->role;

        // Super Admin has access to everything
        if ($userRole === 'super_admin') {
            return $next($request);
        }

        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized access. You do not have permission for this section.');
        }

        return $next($request);
    }
}
