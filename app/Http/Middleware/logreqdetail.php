<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class logreqdetail
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        Log::channel('daily')->info('Post Route Request', [
            'method'      => $request->method(),
            'url'         => $request->fullUrl(),
            'user_id'     => auth()->id() ?? 'guest',
            'ip'          => $request->ip(),
            'user_agent'  => $request->userAgent(),
            'status_code' => $response->getStatusCode(),
            'timestamp'   => now()->toDateTimeString(),
        ]);
        return $response;
    }
}
