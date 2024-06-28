<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\SpinResponse;
use App\Models\Spin;
use App\Models\Token;

class GameService extends Service
{
    public function spin(string $token): SpinResponse
    {
        $randomNumber = rand(1, 1000);
        $isWinner = $randomNumber % 2 === 0;

        if ($isWinner) {
            if ($randomNumber > 900) {
                $winningAmount = 0.7 * $randomNumber;
            } elseif ($randomNumber > 600) {
                $winningAmount = 0.5 * $randomNumber;
            } elseif ($randomNumber > 300) {
                $winningAmount = 0.3 * $randomNumber;
            } else {
                $winningAmount = 0.1 * $randomNumber;
            }
        } else {
            $winningAmount = 0;
        }

        try {
            $this->saveResult($token, $randomNumber, round($winningAmount, 2));
        } catch (\Exception $error) {
            throw new \ErrorException('Error during saving a result ' . $error->getMessage());
        }

        return new SpinResponse($randomNumber, round($winningAmount, 2), $isWinner);
    }

    /**
     * @param string $token
     * @return array<SpinResponse>
     */
    public function getSpinHistory(string $token): array
    {
        $userToken = $this->getToken($token);

        $spins = [];
        foreach (Spin::where(['user_id' => $userToken->user_id])->latest()->take(3)->get() as $spin) {
            $spins[] = new SpinResponse($spin->spin, (float) $spin->win, $spin->win > 0);
        }

        return $spins;
    }

    private function saveResult(string $token, int $randomNumber, float $winningAmount): void
    {
        $userToken = Token::where('token', $token)->first();

        Spin::create([
            'user_id' => $userToken->user_id,
            'spin' => $randomNumber,
            'win' => $winningAmount,
        ]);
    }
}
