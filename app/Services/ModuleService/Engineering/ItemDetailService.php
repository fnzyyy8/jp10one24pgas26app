<?php

namespace App\Services\ModuleService\Engineering;


use App\Models\Engineering\ItemDetail\ItemDetail;
use App\Repositories\ModuleRepository\Engineering\ItemDetail\CategoryRepository;
use App\Repositories\ModuleRepository\Engineering\ItemDetail\ItemDetailRepository;
use App\Repositories\ModuleRepository\Engineering\ItemDetail\SectionRepository;
use App\Repositories\ModuleRepository\Engineering\ItemDetail\SubCategoryRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class ItemDetailService
{
    public function __construct(
        protected SectionRepository     $sectionRepository,
        protected CategoryRepository    $categoryRepository,
        protected SubCategoryRepository $subCategoryRepository,
        protected ItemDetailRepository  $repository,
    )
    {
    }

    public function create(array $data): ItemDetail
    {
        try {
            return DB::transaction(function () use ($data) {

                // Section
                $section = $this->sectionRepository->create(
                    $data['section']
                );

                // Category
                $category = null;

                if (filled($data['category']['name'] ?? null)) {
                    $category = $this->categoryRepository->create([
                        'name' => $data['category']['name'],
                        'sort_order' => $data['category']['sort_order'] ?? 0,
                        'section_id' => $section->id,
                    ]);
                }

                // Sub Category
                $subCategory = null;

                if (
                    $category &&
                    filled($data['subCategory']['name'] ?? null)
                ) {
                    $subCategory = $this->subCategoryRepository->create([
                        'name' => $data['subCategory']['name'],
                        'sort_order' => $data['subCategory']['sort_order'] ?? 0,
                        'category_id' => $category->id,
                    ]);
                }

                // Item Detail
                return $this->repository->create([
                    'name' => $data['itemDetail']['name'],
                    'unit' => $data['itemDetail']['unit'],
                    'scope' => $data['itemDetail']['scope'],
                    'sort_order' => $data['itemDetail']['sort_order'],

                    'section_id' => $section->id,
                    'category_id' => $category?->id,
                    'sub_category_id' => $subCategory?->id,
                ]);
            });

        } catch (Throwable $e) {
            Log::error('Failed to create item detail', [
                'message' => $e->getMessage(),
                'data' => $data,
            ]);

            throw new RuntimeException('Failed to create item detail', previous: $e,);
        }
    }

    public function getItemDetailOptions(): array
    {
        return [
            'sections' => $this->sectionRepository->getOptions(),
            'categories' => $this->categoryRepository->getOptions(),
            'subCategories' => $this->subCategoryRepository->getOptions(),
        ];
    }

    public function update(int $id, array $data): ItemDetail
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $itemDetail = $this->repository->findById($id);
                return $this->repository->update($itemDetail, $data);
            });
        } catch (Throwable $e) {
            Log::error('Failed to update item detail', [
                'item_detail_id' => $id,
                'message' => $e->getMessage(),
                'data' => $data,
            ]);
            throw new RuntimeException(
                'Failed to update item detail',
                previous: $e
            );
        }

    }

    public function delete(int $id): void
    {
        try {

            $itemDetail = $this->repository->findById($id);

            $this->repository->delete($itemDetail);
        } catch (Throwable $e) {
            Log::error('Failed to delete item detail', [
                'item_detail_id' => $id,
                'message' => $e->getMessage(),
            ]);
            throw new RuntimeException('Failed to delete item detail', previous: $e,);
        }

    }

    public function getAll(): Enumerable
    {
        return $this->repository->getAll()
            ->groupBy('section_id')
            ->map(function (Collection $sectionGroup) {
                $section = $sectionGroup->first()->section;
                return [
                    'id' => $section->id,
                    'name' => $section->name,
                    'itemDetails' => $sectionGroup->whereNull('category_id')->values(),
                    'categories' => $this->buildCategoriesTree($sectionGroup->whereNotNull('category_id')),
                ];
            });
    }

    private function buildCategoriesTree(Collection $itemDetails): Enumerable
    {
        return $itemDetails
            ->groupBy('category_id')
            ->map(function (Collection $categoryGroup) {
                $category = $categoryGroup->first()->category;

                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'itemDetails' => $categoryGroup->whereNull('sub_category_id')->values(),
                    'subCategories' => $categoryGroup
                        ->whereNotNull('sub_category_id')
                        ->groupBy('sub_category_id')
                        ->map(function (Collection $subCategoryGroup) {
                            $subCategory = $subCategoryGroup->first()->subCategory;
                            return [
                                'id' => $subCategory->id,
                                'name' => $subCategory->name,
                                'itemDetails' => $subCategoryGroup->values(),
                            ];

                        })->values()
                ];
            })->values();
    }
}
