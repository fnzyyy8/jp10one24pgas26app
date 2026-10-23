<?php

namespace App\Repositories\ModuleRepository\Engineering;

use App\Models\Engineering\PriceList\PriceList;
use Illuminate\Support\Collection;

class PriceListRepository
{
    public function __construct(
        protected PriceList $model
    )
    {
    }

    public function getAll(): Collection
    {
        return $this->model
            ->newQuery()
            ->withCount('unitPrices')
            ->get();
    }

    public function findById(int $id): PriceList
    {
        return $this->model
            ->newQuery()
            ->findOrFail($id);
    }

    public function findByIdWithPrices(int $id): PriceList
    {
        return $this->model
            ->newQuery()->select('id', 'name', 'number', 'client')
            ->with(
                [
                    'unitPrices.itemDetail' => function ($query) {
                        $query->with([
                            'section:id,name',
                            'category:id,name',
                            'subCategory:id,name'
                        ]);
                    },
                    'unitPrices.latestRecordPrice'
                ]
            )
            ->findOrFail($id);
    }

    public function create(array $data): PriceList
    {
        return $this->model
            ->newQuery()
            ->create($data);
    }

    public function update(PriceList $priceList, array $data): PriceList
    {
        $priceList->update($data);
        return $priceList->fresh();
    }

    public function delete(PriceList $priceList): bool
    {
        return (bool)$priceList->delete();
    }

}
