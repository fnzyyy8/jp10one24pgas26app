<?php

namespace App\Services\ModuleService\ProjectControl;

use App\Models\ProjectControl\Plan;
use App\Repositories\ModuleRepository\ProjectControl\PlanRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;


class PlanService
{
    public function __construct(
        protected PlanRepository $repository,
    )
    {
    }

    public function getAllByBoqId(int $boqId): Collection
    {
        return $this->repository->getAllByBoqId($boqId);
    }

    public function getGroupByBoqId(int $boqId): Enumerable
    {
        return $this->getAllByBoqId($boqId)
            ->groupBy('unitPrice.itemDetail.section_id')
            ->map(fn(Collection $plans) => [
                'id' => $plans->first()->unitPrice->itemDetail->section->id,
                'name' => $plans->first()->unitPrice->itemDetail->section->name,
                'plans' => $plans->whereNull('unitPrice.itemDetail.category_id')->values(),
                'categories' => $this->buildByCategoriesTrees($plans->whereNotNull('unitPrice.itemDetail.category_id')),
            ]);

    }


    private function buildByCategoriesTrees(Collection $unitPrices): Enumerable
    {
        return $unitPrices->groupBy('unitPrice.itemDetail.category_id')
            ->map(function (Collection $categoryGroup) {
                $category = $categoryGroup->first()->unitPrice->itemDetail->category;
                return [
                    'id' => $category?->id,
                    'name' => $category?->name,
                    'plans' => $categoryGroup->whereNull('unitPrice.itemDetail.sub_category_id')->values(),

                    'subCategories' => $categoryGroup
                        ->whereNotNull('unitPrice.itemDetail.sub_category_id')
                        ->groupBy('unitPrice.itemDetail.sub_category_id')
                        ->map(function (Collection $subCategoryGroup) {
                            $subCategory = $subCategoryGroup->first()->unitPrice->itemDetail->subCategory;
                            return [
                                'id' => $subCategory?->id,
                                'name' => $subCategory?->name,
                                'plans' => $subCategoryGroup->whereNotNull('unitPrice.itemDetail.sub_category_id')->values(),
                            ];
                        })->values(),
                ];
            })->values();
    }

    public function sync(int $boqId, array $unitPriceIds): bool
    {
        try {
            return DB::transaction(function () use ($boqId, $unitPriceIds) {
                $this->repository->deleteUnselectedUnitPrices($boqId, $unitPriceIds);

                foreach ($unitPriceIds as $unitPriceId) {
                    $this->repository->createSelectedUnitPrices($boqId, $unitPriceId);
                }

                return true;
            });

        } catch (Throwable $e) {
            Log::error('Failed to sync Plan', [
                'boq_id' => $boqId,
                'item_detail_ids' => $unitPriceIds,
                'message' => $e->getMessage()
            ]);
            throw new RuntimeException('Failed to sync Plan', previous: $e);
        }
    }

    public function update(Plan $plan, array $data): Plan
    {
        try {
            return DB::transaction(function () use ($plan, $data) {

                return $this->repository->update($plan, $data);
            });

        } catch (Throwable $e) {
            Log::error('Failed to update Plan', [
                'boq_id' => $plan->id,
                'item_detail_id' => $data['item_detail_id'],
                'message' => $e->getMessage()
            ]);

            throw new RuntimeException(
                'Failed to update Plan',
                previous: $e
            );
        }

    }


}
