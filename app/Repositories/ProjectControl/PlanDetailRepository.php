<?php

namespace App\Repositories\ProjectControl;

use App\Models\ProjectControl\PlanDetail;
use Illuminate\Support\Collection;

class PlanDetailRepository
{
    public function __construct(
        protected PlanDetail $model,
    )
    {
    }

    public function findById(int $planId): PlanDetail
    {
        return $this->model
            ->newQuery()
            ->findOrFail($planId);
    }

    public function findByPlanId(int $planId): Collection
    {
        return $this->model
            ->newQuery()
            ->where('plan_id', $planId)
            ->with([
                'plan',
                'plan.boq'
            ])->get();

    }

    public function findAll(int $planId): Collection
    {
        return $this->model
            ->newQuery()
            ->where('plan_id', $planId)
            ->with([
                'plan',
                'plan.unitPrice',
                'plan.unitPrice.itemDetail'
            ])
            ->get();
    }

    public function create(array $data): PlanDetail
    {
        return $this->model
            ->newQuery()
            ->create($data);
    }

    public function update(PlanDetail $planDetail, array $data): PlanDetail
    {
        $planDetail->update($data);
        return $planDetail->fresh();
    }

    public function delete(PlanDetail $planDetail): bool
    {
        return (bool)$planDetail->delete();
    }
}
