<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyTokenPageAccess extends VerifyTokenAbstract
{
    public function handle(Request $request, Closure $next)
    {
        if ($this->isTokenValid($request->route('token'))) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
