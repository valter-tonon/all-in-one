<?php

namespace App\Domain\Entities;

use Database\Factories\StockFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'price',
        'sku',
        'category',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function isLowStock(): bool
    {
        return $this->quantity <= 5;
    }

    public function isOutOfStock(): bool
    {
        return $this->quantity <= 0;
    }

    public function getTotalValue(): float
    {
        return $this->price * $this->quantity;
    }
    
    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return StockFactory::new();
    }
} 