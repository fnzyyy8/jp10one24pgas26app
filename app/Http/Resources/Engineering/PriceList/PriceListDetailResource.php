<?php

namespace App\Http\Resources\Engineering\PriceList;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class PriceListDetailResource extends JsonResource
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
            'name' => $this->name,
            'number' => $this->number,
            'client' => $this->client,
            'sections' => $this->mapSections()
        ];
    }

    private function mapSections(): array
    {
        return $this->unitPrices
            ->groupBy('itemDetail.section_id')
            ->map(fn(Collection $unitPrices) => $this->mapSection($unitPrices))
            ->values()
            ->all();
    }

    private function mapSection(Collection $unitPrices): array
    {
        $section = $unitPrices->first()->itemDetail->section;
        return [
            'id' => $section->id,
            'name' => $section->name,
            'itemDetails' => $unitPrices
                ->filter(fn($unitPrice) => is_null($unitPrice->itemDetail->category_id)
                )
                ->map(fn($unitPrice) => $this->mapItem($unitPrice)
                )->values()
                ->all(),
            'category' => $unitPrices
                ->filter(fn($unitPrice) => !is_null($unitPrice->itemDetail->category_id)
                )->groupBy('itemDetail.category_id')
                ->map(fn(Collection $categoryPrices) => $this->mapCategory($categoryPrices)
                )->values()
                ->all()
        ];
    }

    private function mapCategory(Collection $unitPrices): array
    {
        $category = $unitPrices
            ->first()
            ->itemDetail
            ->category;
        return [
            'id' => $category->id,
            'name' => $category->name,
            'itemDetails' => $unitPrices
                ->filter(fn($unitPrice) => is_null($unitPrice->itemDetail->sub_category_id))
                ->map(fn($unitPrice) => $this->mapItem($unitPrice))
                ->values()
                ->all(),
            'subCategory' => $unitPrices
                ->filter(fn($unitPrice) => !is_null($unitPrice->itemDetail->sub_category_id)
                )->groupBy('itemDetail.sub_category_id')
                ->map(fn(Collection $subCategoryPrices) => $this->mapSubCategory($subCategoryPrices)
                )
                ->values()
                ->all()
        ];
    }

    private function mapSubCategory(Collection $unitPrices): array
    {
        $subCategory = $unitPrices
            ->first()
            ->itemDetail
            ->subCategory;
        return [
            'id' => $subCategory->id,
            'name' => $subCategory->name,
            'itemDetails' => $unitPrices
                ->map(fn($unitPrice) => $this->mapItem($unitPrice)
                )
                ->values()
                ->all()
        ];
    }

    private function mapItem($unitPrice): array
    {
        return [
            'id' => $unitPrice->id,
            'name' => $unitPrice->itemDetail->name,
            'unit' => $unitPrice->itemDetail->unit,
            'price' => $unitPrice->latestRecordPrice?->price ?? 0,
        ];
    }
}
