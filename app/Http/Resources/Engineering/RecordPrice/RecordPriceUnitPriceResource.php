<?php

namespace App\Http\Resources\Engineering\RecordPrice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecordPriceUnitPriceResource extends JsonResource
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
            'section' => $this->itemDetail->section->name,
            'category' => $this->itemDetail->category->name ?? '-',
            'subCategory' => $this->itemDetail->subCategory->name ?? '-',
            'name' => $this->itemDetail->name,
            'unit' => $this->itemDetail->unit

        ];
    }
}
