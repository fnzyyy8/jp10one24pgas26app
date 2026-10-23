<?php

namespace App\Repositories\ModuleRepository\Engineering\ItemDetail;

use App\Models\Engineering\ItemDetail\ItemDetail;
use Illuminate\Support\Collection;

class ItemDetailRepository
{
    public function __construct(
        protected ItemDetail $model
    )
    {
    }

    public function getAll(): Collection
    {
        return $this->model
            ->newQuery()
            ->with([
                'section',
                'category',
                'subCategory',
            ])
            ->orderBy('section_id')
            ->orderBy('category_id')
            ->orderBy('sub_category_id')
            ->orderBy('sort_order')
            ->get();
    }

    public function findById(int $id): ItemDetail
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function getByIds(array $ids): Collection
    {
        return $this->model
            ->newQuery()
            ->whereIn('id', $ids)
            ->with(['section,category,subCategory'])
            ->get();
    }

    public function create(array $data): ItemDetail
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(ItemDetail $itemDetail, array $data): ItemDetail
    {
        $itemDetail->update($data);

        return $itemDetail->fresh();
    }

    public function delete(ItemDetail $itemDetail): bool
    {
        return (bool)$itemDetail->delete();
    }

}
