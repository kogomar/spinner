<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Token;
use App\Models\User;
use App\Services\TokenService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request, TokenService $tokenService): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:users',
        ]);

        $user = User::create($request->only('name', 'phone'));
        $token = Str::random(Token::TOKEN_LENGTH);

        $tokenService->createToken($user->user_id, $token);

        return redirect()->route('game', ['token' => $token]);
    }
}
