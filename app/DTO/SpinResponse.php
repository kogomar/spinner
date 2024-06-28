<?php

declare(strict_types=1);

namespace App\DTO;

class SpinResponse
{
    public function __construct(
        public readonly int $spin,
        public readonly float $win,
        public readonly bool $isWinner,
    ) {
    }
}
