<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class user_active
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && ! auth()->user()->is_active) {
            auth()->logout();
            return redirect()->route('suspended')
                ->with('error', 'Your account has been suspended. Please contact support.');
        }
        return $next($request);
    }
}
