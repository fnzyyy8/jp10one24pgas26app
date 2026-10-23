<?php

namespace App\Http\Resources\ProjectControl\Plan;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
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
            'name' => data_get($this->resource, 'name'),
            'plans' => $this->formatUnitPrices(data_get($this->resource, 'plans')),
            'categories' => $this->formatCategories(data_get($this->resource, 'categories')),
        ];
    }

    private function formatUnitPrices(mixed $unitPrices): array
    {

        return collect($unitPrices)->map(function ($unit) {

            $planDetails = data_get($unit, 'planDetails')->sum('volume');
            $percentage = ($planDetails / data_get($unit, 'volume')) * 100 ?? 0;

            return [
                'id' => data_get($unit, 'id'),
                'boq_id' => data_get($unit, 'boq_id'),
                'unit_price_id' => data_get($unit, 'unit_price_id'),
                'section' => data_get($unit, 'unitPrice.itemDetail.section.name'),
                'category' => data_get($unit, 'unitPrice.itemDetail.category.name'),
                'subCategory' => data_get($unit, 'unitPrice.itemDetail.subCategory.name'),
                'name' => data_get($unit, 'unitPrice.itemDetail.name'),
                'unit' => data_get($unit, 'unitPrice.itemDetail.unit'),
                'price' => data_get($unit, 'unitPrice.latestRecordPrice.price'),
                'volume' => data_get($unit, 'volume'),
                'percentage' => $percentage
            ];
        })->values()->all();
    }

    private function formatCategories(mixed $categories): array
    {
        return collect($categories)->map(function ($category) {
            return [
                'id' => data_get($category, 'id'),
                'name' => data_get($category, 'name'),
                'plans' => $this->formatUnitPrices(data_get($category, 'plans')),
                'subCategories' => $this->formatSubCategories(data_get($category, 'subCategories')),
            ];
        })->values()->all();
    }

    private function formatSubCategories(mixed $subCategories): array
    {
        return collect($subCategories)->map(function ($subCategory) {
            return [
                'id' => data_get($subCategory, 'id'),
                'name' => data_get($subCategory, 'name'),
                'plans' => $this->formatUnitPrices(data_get($subCategory, 'plans')),
            ];
        })->values()->all();
    }
}
