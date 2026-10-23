<?php

namespace App\Repositories\Engineering;

use App\Models\Engineering\PriceList\RecordPrice;
use Illuminate\Support\Collection;

class RecordPriceRepository
{

    public function __construct(
        protected RecordPrice $model
    )
    {
    }

    public function findById(int $id): RecordPrice
    {
        return $this->model
            ->query()
            ->findOrFail($id);
    }

    public function getByUnitPriceId(int $unitPriceId): Collection
    {
        return $this->model
            ->newQuery()
            ->where('unit_price_id', $unitPriceId)
            ->latest('date')
            ->get();
    }

    public function create(array $data): RecordPrice
    {
        return $this->model
            ->newQuery()
            ->create([
                'unit_price_id' => $data['unit_price_id'],
                'date' => $data['date'],
                'price' => $data['price'],
                'notes' => $data['notes'] ?? null,
            ]);
    }

    public function delete(RecordPrice $recordPrice): bool
    {
        return (bool)$recordPrice->delete();
    }

}
