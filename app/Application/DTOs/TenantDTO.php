<?php

namespace App\Application\DTOs;

class TenantDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $database,
        public readonly ?string $domain = null,
        public readonly string $plan = 'basic',
        public readonly string $status = 'active',
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            database: $data['database'],
            domain: $data['domain'] ?? null,
            plan: $data['plan'] ?? 'basic',
            status: $data['status'] ?? 'active',
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'database' => $this->database,
            'domain' => $this->domain,
            'plan' => $this->plan,
            'status' => $this->status,
        ];
    }
} 