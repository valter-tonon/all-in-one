<?php

namespace App\Application\DTOs;

class StockDTO
{
    public function __construct(
        public readonly string $name,
        public readonly int $quantity,
        public readonly float $price,
        public readonly ?string $description = null,
        public readonly ?string $sku = null,
        public readonly ?string $category = null,
        public readonly string $status = 'active',
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            quantity: (int) $data['quantity'],
            price: (float) $data['price'],
            description: $data['description'] ?? null,
            sku: $data['sku'] ?? null,
            category: $data['category'] ?? null,
            status: $data['status'] ?? 'active',
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'description' => $this->description,
            'sku' => $this->sku,
            'category' => $this->category,
            'status' => $this->status,
        ];
    }
} 