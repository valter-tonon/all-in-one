<?php

namespace App\Interfaces\Http\Resources;

use App\Domain\Entities\Stock;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        /** @var Stock $this */
        return [
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'quantity' => $this->quantity,
                'price' => $this->price,
                'sku' => $this->sku,
                'category' => $this->category,
                'status' => $this->status,
                'is_low_stock' => $this->isLowStock(),
                'is_out_of_stock' => $this->isOutOfStock(),
                'total_value' => $this->getTotalValue(),
                'created_at' => $this->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            ]
        ];
    }
} 