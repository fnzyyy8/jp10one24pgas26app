<?php

namespace App\Services\ProjectControl;

use App\Exceptions\ProjectControl\BoqHasPlanException;
use App\Models\ProjectControl\Boq;
use App\Repositories\ProjectControl\BoqRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Throwable;
use RuntimeException;

class BoqService
{
    public function __construct(
        protected BoqRepository $repository,
    )
    {
    }

    public function getAll(): Collection
    {
        return $this->repository
            ->getAll()
            ->map(function (Boq $boq) {
                $boq->planBudget = $boq->plans->sum(function ($plan) {
                    $price = $plan->unitPrice->latestRecordPrice?->price ?? 0;
                    $volume = $plan->volume ?? 0;
                    return $volume * $price;
                });

                return $boq;

            });
    }

    public function formBoqOptions(?string $category = null): array
    {

        $projects = $this->repository
            ->getProjectForBoq();

        $categories = $projects
            ->pluck('category')
            ->filter()
            ->unique()
            ->values();

        if ($category !== null) {
            $projects = $projects
                ->where(
                    'category',
                    $category)
                ->values();
        }

        return [
            'categories' => $categories,
            'projects' => $projects,
        ];

    }

    public function getById(int $id): Boq
    {
        return $this->repository->findById($id);

    }

    public function create(array $data): Boq
    {
        try {
            return DB::transaction(function () use ($data) {

                return $this->repository->create($data);

            });

        } catch (Throwable $e) {

            Log::error('Failed to create Boq.', [
                'message' => $e->getMessage(),
                'data' => $data,
            ]);
            throw new RuntimeException(
                'Failed to create Boq.',
                previous: $e);
        }

    }

    /**
     * Update BOQ
     *
     * @throws RuntimeException
     */
    public function update(int $id, array $data): Boq
    {
        try {
            return DB::transaction(function () use ($id, $data) {

                $boq = $this->repository->findById($id);

                return $this->repository
                    ->update(
                        $boq,
                        $data
                    );
            });

        } catch (Throwable $e) {
            Log::error('Failed to update Boq.', [
                'boq_id' => $id,
                'message' => $e->getMessage(),
                'data' => $data,
            ]);

            throw new RuntimeException(
                'Failed to update Boq.',
                previous: $e
            );
        }

    }

    /**
     * Delete BOQ
     *
     * @throws BoqHasPlanException
     * @throws RuntimeException
     */
    public function delete(int $id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $boq = $this->repository->findById($id);

                return $this->repository->delete($boq);
            });

        } catch (BoqHasPlanException $e) {
            Log::error('Failed to delete Boq.', [
                'boq_id' => $id,
                'message' => $e->getMessage(),
            ]);
            throw  $e;

        } catch (Throwable $e) {
            Log::error('Failed to delete Boq.', [
                'boq_id' => $id,
                'message' => $e->getMessage(),
            ]);

            throw new RuntimeException(
                'Failed to delete Boq.',
                previous: $e
            );
        }
    }

}
