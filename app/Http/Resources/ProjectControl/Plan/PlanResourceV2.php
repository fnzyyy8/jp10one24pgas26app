<?php

namespace App\Http\Resources\ProjectControl\Plan;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResourceV2 extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $volumePlanDetails = data_get($this->resource, 'planDetails')->sum('volume');
        $volumePlan = data_get($this->resource, 'volume');
        $percentage = ($volumePlanDetails / $volumePlan) * 100;
        return [
            'id' => data_get($this->resource, 'id'),
            'boq_id' => data_get($this->resource, 'boq.id'),
            'unit_price_id' => data_get($this->resource, 'unitPrice.id'),
            'section' => data_get($this->resource, 'unitPrice.itemDetail.section.name'),
            'category' => data_get($this->resource, 'unitPrice.itemDetail.category.name'),
            'subCategory' => data_get($this->resource, 'unitPrice.itemDetail.subCategory.name'),
            'name' => data_get($this->resource, 'unitPrice.itemDetail.name'),
            'unit' => data_get($this->resource, 'unitPrice.itemDetail.unit'),
            'price' => data_get($this->resource, 'unitPrice.latestRecordPrice.price'),
            'volume' => data_get($this->resource, 'volume'),
            'percentage' => $percentage,
        ];
    }
}
