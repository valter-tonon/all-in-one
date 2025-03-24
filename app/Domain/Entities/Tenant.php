<?php

namespace App\Domain\Entities;

use Database\Factories\TenantFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'database',
        'domain',
        'plan',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getConnectionName()
    {
        return 'landlord';
    }
    
    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return TenantFactory::new();
    }
} 