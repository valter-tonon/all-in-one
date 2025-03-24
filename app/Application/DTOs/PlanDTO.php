<?php

namespace App\Application\DTOs;

class PlanDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description,
        public readonly float $price,
        public readonly ?array $features,
        public readonly string $status = 'active',
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'] ?? null,
            price: (float) $data['price'],
            features: $data['features'] ?? null,
            status: $data['status'] ?? 'active',
        );
    }
} 