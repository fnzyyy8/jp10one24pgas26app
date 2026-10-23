<?php

namespace App\Services\ModuleService\Engineering;

use App\Models\Engineering\PriceList\RecordPrice;
use App\Repositories\ModuleRepository\Engineering\RecordPriceRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class RecordPriceService
{
    public function __construct(
        protected RecordPriceRepository $repository,
    )
    {
    }

    public function getByUnitPriceId(int $id): Collection
    {
        return $this->repository->getByUnitPriceId($id);
    }

    public function create(array $data): RecordPrice
    {
        try {
            return DB::transaction(function () use ($data) {
                return $this->repository->create($data);
            });
        } catch (Throwable $e) {
            Log::error('failed to create recordPrice: ', [
                'message' => $e->getMessage(),
            ]);

            throw new RuntimeException('failed to create recordPrice', previous: $e);
        }
    }

    public function delete(int $id): void
    {
        try {
            $recordPrice = $this->repository->findById($id);

            $recordPrice->delete();

        } catch (Throwable $e) {
            Log::error('failed to delete recordPrice: ', [
                'record_price_id' => $id,
                'message' => $e->getMessage(),
            ]);
            throw new RuntimeException(
                'failed to delete recordPrice',
                previous: $e
            );
        }
    }

}
