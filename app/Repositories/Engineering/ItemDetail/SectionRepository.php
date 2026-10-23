<?php

namespace App\Repositories\Engineering\ItemDetail;

use App\Models\Engineering\ItemDetail\Section;
use Illuminate\Support\Collection;

class SectionRepository
{
    public function __construct(
        protected Section $model
    )
    {
    }

    public function getAll(): Collection
    {
        return $this->model->newQuery()->get();
    }

    public function getById(int $id): Section
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): Section
    {
        return $this->model
            ->newQuery()
            ->firstOrCreate($data);
    }

    public function update(Section $section, array $data): Section
    {
        $section->update($data);

        return $section->fresh();
    }

    public function delete(Section $section): bool
    {
        return (bool)$section->delete();
    }

    public function getOptions(): Collection
    {
        return $this->model
            ->newQuery()
            ->select([
                'id',
                'name',
                'sort_order',
            ])->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    public function getTree(): Collection
    {
        return $this->model->newQuery()
            ->with([
                'itemDetails' => function ($query) {
                    $query->whereNull('category_id');
                },
                'categories' => function ($query) {
                    $query->orderBy('sort_order')->orderBy('name');
                },
                'categories.itemDetails' => function ($query) {
                    $query->whereNull('sub_category_id');
                },
                'categories.subCategories' => function ($query) {
                    $query->orderBy('sort_order')->orderBy('name');
                },
                'categories.subCategories.itemDetails' => function ($query) {
                    $query->orderBy('sort_order')->orderBy('id');
                }
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

    }
}
