<?php

namespace App\Http\Resources\ProjectControl\PlanDetail;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanDetailResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => data_get($this->resource, 'id'),
            'date' => data_get($this->resource, 'plan_date'),
            'volume' => data_get($this->resource, 'volume'),
            'unit' => data_get($this->resource, 'plan.unitPrice.itemDetail.unit'),
        ];
    }
}
