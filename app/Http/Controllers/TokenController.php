<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Token;
use App\Services\TokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function generateUrl(Request $request, TokenService $service): JsonResponse
    {
        return response()->json(['data' => $service->generateUrl($request)]);
    }

    public function changeStatus(Token $token, string $status, TokenService $service): JsonResponse
    {
        try {
            $service->changeStatus($token, $status);
        } catch (\Exception $error) {
            return response()->json($error->getMessage(), 401);
        }

        return response()->json('', 204);
    }
}
