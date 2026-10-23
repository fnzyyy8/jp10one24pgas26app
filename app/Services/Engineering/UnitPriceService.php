<?php

namespace App\Services\Engineering;

use App\Models\Engineering\PriceList\UnitPrice;
use App\Repositories\Engineering\ItemDetail\ItemDetailRepository;
use App\Repositories\Engineering\ItemDetail\SectionRepository;
use App\Repositories\Engineering\RecordPriceRepository;
use App\Repositories\Engineering\UnitPriceRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class UnitPriceService
{
    public function __construct(
        protected UnitPriceRepository   $unitPriceRepository,
        protected RecordPriceRepository $recordPriceRepository,
        protected ItemDetailRepository  $itemDetailRepository,
        protected SectionRepository     $sectionRepository,
    )
    {
    }

    public function getAllItemDetails(): Collection
    {
        return $this->sectionRepository->getTree();
    }

    public function getPriceByPriceListId(int $priceListId): Collection
    {
        return $this->unitPriceRepository->getByPriceListId($priceListId);
    }

    public function getUnitPrice(int $unitPriceId): UnitPrice
    {
        return $this->unitPriceRepository->findById($unitPriceId);
    }

    public function getGroupByPriceListId(int $priceListId): Enumerable
    {
        return $this->unitPriceRepository
            ->getByPriceListId($priceListId)
            ->groupBy('itemDetail.section_id')
            ->map(fn(Collection $unitPrices) => [
                'id' => $unitPrices->first()->itemDetail->section?->id,
                'name' => $unitPrices->first()->itemDetail->section?->name,
                'sort_order' => $unitPrices->first()->itemDetail->section?->sort_order,
                'itemDetails' => $unitPrices
                    ->whereNull('itemDetail.category_id')
                    ->sortByDesc('itemDetail.sort_order')
                    ->values(),
                'categories' => $this->buildCategoriesTree($unitPrices->whereNotNull('itemDetail.category_id'))
            ]);
    }

    private function buildCategoriesTree(Collection $unitPrices): Enumerable
    {
        return $unitPrices
            ->groupBy('itemDetail.category_id')
            ->map(function (Collection $categoryGroup) {
                $category = $categoryGroup->first()->itemDetail->category;

                return [
                    'id' => $category?->id,
                    'name' => $category?->name,
                    'sort_order' => $category?->sort_order,
                    'itemDetails' => $categoryGroup
                        ->whereNull('itemDetail.sub_category_id')
                        ->sortBy('itemDetail.sort_order')
                        ->values(),

                    'subCategories' => $categoryGroup
                        ->whereNotNull('itemDetail.sub_category_id')
                        ->groupBy('itemDetail.sub_category_id')
                        ->map(function (Collection $subCategoryGroup) {
                            $subCategory = $subCategoryGroup
                                ->first()
                                ->itemDetail
                                ->subCategory;
                            return [
                                'id' => $subCategory?->id,
                                'name' => $subCategory?->name,
                                'sort_order' => $subCategory?->sort_order,
                                'itemDetails' => $subCategoryGroup
                                    ->sortBy('itemDetail.sort_order')
                                    ->values(),
                            ];
                        })
                        ->sortBy('sort_order')->values(),
                ];
            })->sortBy('sort_order')->values();
    }

    public function sync(int $priceListId, array $itemDetailIds): bool
    {
        try {
            return DB::transaction(function () use ($priceListId, $itemDetailIds) {

                $this->unitPriceRepository->deleteUnselectedItemDetails($priceListId, $itemDetailIds);

                foreach ($itemDetailIds as $itemDetailId) {
                    $this->unitPriceRepository->firstOrCreate($priceListId, $itemDetailId);
                }
                return true;
            });
        } catch (Throwable $e) {
            Log::error('Failed to sync batch: ', [
                'price_list_id' => $priceListId,
                'item_detail_ids' => $itemDetailIds,
                'message' => $e->getMessage(),
            ]);

            throw new RuntimeException('Failed to sync batch', previous: $e);
        }

    }
}
