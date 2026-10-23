<?php

namespace App\Services\ModuleService\ProjectControl;

use App\Models\ProjectControl\PlanDetail;
use App\Repositories\ModuleRepository\ProjectControl\PlanDetailRepository;
use App\Repositories\ModuleRepository\ProjectControl\PlanRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use RuntimeException;
use Throwable;

class PlanDetailService
{
    public function __construct(
        protected PlanDetailRepository $repository,
        protected PlanRepository       $planRepository,

    )
    {
    }

    public function getAllByPlan(int $planId): Collection
    {
        return $this->repository->findAll($planId);
    }

    public function getByPlanId(int $planId): Collection
    {
        return $this->planRepository->getAllByPlanId($planId);

    }


    public function create(array $data): PlanDetail
    {

        try {
            return DB::transaction(function () use ($data) {
                $plan = $this->planRepository->findById($data['plan_id']);

                $totalVolume = $plan->planDetails()->sum('volume');
                $newTotalVolume = $totalVolume + $data['volume'];

                if ($newTotalVolume > $plan->volume) {
                    throw new InvalidArgumentException('Total volume Plan Detail melebihi batas volume');
                }

                return $this->repository->create($data);
            });
        } catch (Throwable $e) {

            throw new RuntimeException('Failed to create plan detail', previous: $e);
        }
    }

    public function delete(int $id): void
    {
        try {
            DB::transaction(function () use ($id) {
                $plan = $this->repository->findById($id);
                $this->repository->delete($plan);
            });
        } catch (Throwable $e) {
            Log::error('Failed to delete plan detail', ['exception' => $e]);
            throw new RuntimeException('Failed to delete plan detail', previous: $e);
        }

    }
}
