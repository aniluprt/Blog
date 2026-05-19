<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class checkpermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }
        $user = auth()->user();
        $user->loadMissing(['role.permissions', 'permissions']);
        if (! $user->hasPermission($permission)) {
            abort(403, 'You do not have permission to access this page.');
        }
        return $next($request);
    }
}
