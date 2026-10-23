<?php

namespace App\Http\Resources\Engineering\RecordPrice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecordPriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'unit_price_id' => $this->unit_price_id,
            'date' => $this->date?->format('Y-m-d'),
            'price' => $this->price,
            'notes' => $this->notes,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
