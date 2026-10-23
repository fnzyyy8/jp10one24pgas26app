<?php

namespace App\Http\Resources\ProjectControl\Plan;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanUpdateUnitPriceResource extends JsonResource
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
            'unitPrices' => $this->formatUnitPrices(data_get($this->resource, 'itemDetails')),
            'categories' => $this->formatCategories(data_get($this->resource, 'categories')),
        ];
    }

    private function formatCategories(mixed $categories): array
    {
        return collect($categories)->map(fn($category) => [
            'id' => data_get($category, 'id'),
            'name' => data_get($category, 'name'),
            'subCategories' => $this->formatSubCategories(data_get($category, 'subCategories')),
            'unitPrices' => $this->formatUnitPrices(data_get($category, 'itemDetails')),
        ])->values()->all();

    }

    private function formatSubCategories(mixed $subCategories): array
    {
        return collect($subCategories)->map(fn($subCategory) => [
            'id' => data_get($subCategory, 'id'),
            'name' => data_get($subCategory, 'name'),
            'unitPrices' => $this->formatUnitPrices(data_get($subCategory, 'itemDetails')),
        ])->values()->all();

    }

    private function formatUnitPrices(mixed $unitPrice): array
    {
        return collect($unitPrice)->map(fn($price) => [
            'id' => data_get($price, 'id'),
            'name' => data_get($price, 'itemDetail.name'),
            'unit' => data_get($price, 'itemDetail.unit'),
            'price' => data_get($price, 'latestRecordPrice.price'),
        ])->values()->all();

    }


}
