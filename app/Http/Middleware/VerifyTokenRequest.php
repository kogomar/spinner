<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyTokenRequest extends VerifyTokenAbstract
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if ($token && $this->isTokenValid($token)) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
