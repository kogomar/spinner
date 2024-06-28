<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\GameService;
use App\Services\TokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GameController extends Controller
{
    public function show(string $token, Request $request, TokenService $tokenService): View
    {
        $userUrls = $tokenService->getUserUrls($request, $token);

        return view('game', compact('userUrls'));
    }

    public function spin(Request $request, GameService $gameService): JsonResponse
    {
        return response()->json(['data' => $gameService->spin($request->bearerToken())]);
    }

    public function spinHistory(Request $request, GameService $gameService): JsonResponse
    {
        return response()->json(['data' => $gameService->getSpinHistory($request->bearerToken())]);
    }
}
