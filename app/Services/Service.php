<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\SpinResponse;
use App\Models\Spin;
use App\Models\Token;

class Service
{
    protected function getToken(string $token): Token
    {
        return Token::where('token', $token)->first();
    }
}
