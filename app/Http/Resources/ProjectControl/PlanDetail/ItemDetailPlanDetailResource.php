<?php

namespace App\Http\Resources\ProjectControl\PlanDetail;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemDetailPlanDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $plan = $this->resource;

        $totalVolume = $plan ? $plan->planDetails->sum('volume') : 0;
        return [
            'section' => data_get($this->resource, 'unitPrice.itemDetail.section.name'),
            'category' => data_get($this->resource, 'unitPrice.itemDetail.category.name') ?? '-',
            'subCategory' => data_get($this->resource, 'unitPrice.itemDetail.subCategory.name') ?? '-',
            'name' => data_get($this->resource, 'unitPrice.itemDetail.name'),
            'volume' => data_get($this->resource, 'volume'),
            'totalVolume' => (float)$totalVolume,
        ];
    }
}
