<?php

namespace App\Http\Resources\Engineering\UnitPrice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitPriceResource extends JsonResource
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
            'itemDetails' => $this->formatItemDetails(data_get($this->resource, 'itemDetails')),
            'categories' => $this->formatCategories(data_get($this->resource, 'categories')),
        ];
    }

    public function formatCategories(mixed $categories): array
    {
        return collect($categories)->map(fn($category) => [
            'id' => data_get($category, 'id'),
            'name' => data_get($category, 'name'),
            'itemDetails' => $this->formatItemDetails(data_get($category, 'itemDetails')),
            'subCategories' => $this->formatSubCategories(data_get($category, 'subCategories')),
        ])->values()->all();
    }

    public function formatSubCategories(mixed $subCategories): array
    {
        return collect($subCategories)->map(fn($subCategory) => [
            'id' => data_get($subCategory, 'id'),
            'name' => data_get($subCategory, 'name'),
            'itemDetails' => $this->formatItemDetails(data_get($subCategory, 'itemDetails')),
        ])->values()->all();
    }

    public function formatItemDetails(mixed $itemDetails): array
    {
        return collect($itemDetails)->map(fn($item) => [
            'id' => data_get($item, 'id'),
            'name' => data_get($item, 'name'),
            'unit' => data_get($item, 'unit'),
        ])->values()->all();
    }
}
