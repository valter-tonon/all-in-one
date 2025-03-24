<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Stock;
use Illuminate\Support\Collection;

interface StockRepositoryInterface
{
    public function getAll(): Collection;
    
    public function findById(int $id): ?Stock;
    
    public function findBySku(string $sku): ?Stock;
    
    public function create(array $data): Stock;
    
    public function update(int $id, array $data): ?Stock;
    
    public function delete(int $id): bool;
    
    public function search(string $term): Collection;
    
    public function getLowStock(): Collection;
    
    public function getOutOfStock(): Collection;
} 