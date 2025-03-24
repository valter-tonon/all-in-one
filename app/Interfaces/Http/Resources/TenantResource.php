<?php

namespace App\Interfaces\Http\Resources;

use App\Domain\Entities\Tenant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        /** @var Tenant $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'domain' => $this->domain,
            'plan' => $this->plan,
            'status' => $this->status,
            'is_active' => $this->isActive(),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
} 