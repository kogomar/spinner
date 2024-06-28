<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\UserUrlResponse;
use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TokenService extends Service
{
    public function generateUrl(Request $request): UserUrlResponse
    {
        $newToken = Token::create([
            'user_id' => $this->getToken($request->bearerToken())?->user_id,
            'token' => Str::random(Token::TOKEN_LENGTH),
            'is_active' => 1,
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        $url = $request->root() . '/game/' . $newToken->token;

        return new UserUrlResponse($newToken->id, $url, 1) ;
    }

    /**
     * @return array<UserUrlResponse>
     */
    public function getUserUrls(Request $request, string $token): array
    {
        $userId = $this->getToken($token)->user_id;
        $userTokens = Token::where('user_id',  $userId)->get();

        $urls = [];
        foreach ($userTokens as $token) {
            $url = $request->root() . '/game/' . $token->token;
            $urls[] = new UserUrlResponse($token->id, $url, $token->is_active);
        }

        return $urls;
    }

    public function changeStatus(Token $token, string $status): void
    {
        if (!in_array($status, ['enable', 'disable'])) {
            throw new \Exception('Status is incorrect');
        }

        $token->is_active = $status === 'enable';
        $token->save();
    }

    public function createToken(int $userId, string $token): void
    {
        Token::create([
            'user_id' => $userId,
            'token' => $token,
            'is_active' => true,
            'expires_at' => Carbon::now()->addDays(7),
        ]);
    }
}
