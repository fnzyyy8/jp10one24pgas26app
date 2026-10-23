<?php

namespace App\Repositories\ModuleRepository\Engineering\ItemDetail;

use App\Models\Engineering\ItemDetail\SubCategory;
use Illuminate\Support\Collection;

class SubCategoryRepository
{
    public function __construct(
        protected SubCategory $model
    )
    {
    }

    public function getAll(): Collection
    {
        return $this->model->newQuery()->get();
    }

    public function findById(int $id): SubCategory
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): SubCategory
    {
        return $this->model->newQuery()->firstOrCreate($data);
    }

    public function update(SubCategory $subCategory, array $data): SubCategory
    {
        $subCategory->update($data);
        return $subCategory->fresh();
    }

    public function delete(SubCategory $subCategory): bool
    {
        return (bool)$subCategory->delete();
    }

    public function getOptions(): Collection
    {
        return $this->model
            ->newQuery()
            ->select([
                'id',
                'category_id',
                'name',
                'sort_order',
            ])->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }
}
