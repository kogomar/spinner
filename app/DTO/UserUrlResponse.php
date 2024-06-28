<?php

declare(strict_types=1);

namespace App\DTO;

class UserUrlResponse
{
    public function __construct(
        public readonly int $id,
        public readonly string $url,
        public readonly int $status,
    ) {
    }
}
