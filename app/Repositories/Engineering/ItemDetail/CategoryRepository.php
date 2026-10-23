<?php

namespace App\Repositories\Engineering\ItemDetail;

use App\Models\Engineering\ItemDetail\Category;
use Illuminate\Support\Collection;

class CategoryRepository
{
    public function __construct(
        protected Category $model
    )
    {
    }

    public function getAll(): Collection
    {
        return $this->model->newQuery()->get();
    }

    public function findById(int $id): Category
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): Category
    {
        return $this->model->newQuery()->firstOrCreate($data);
    }

    public function update(Category $category, array $data): Category
    {
        $category->update($data);

        return $category->fresh();
    }

    public function delete(Category $category): bool
    {
        return (bool)$category->delete();
    }

    public function getOptions(): Collection
    {
        return $this->model
            ->newQuery()
            ->select([
                'id',
                'section_id',
                'name',
                'sort_order',
            ])->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }
}
