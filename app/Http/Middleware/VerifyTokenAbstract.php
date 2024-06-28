<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Closure;

abstract class VerifyTokenAbstract
{
    abstract function handle(Request $request, Closure $next);

    protected function isTokenValid(string $token): bool
    {
        if (strlen($token) !== Token::TOKEN_LENGTH) {
            return false;
        }

        $userToken = Token::where('token', $token)->first();

        if (!$userToken || $userToken->expires_at < Carbon::now() || !$userToken->is_active) {
            return false;
        }

        return true;
    }
}
