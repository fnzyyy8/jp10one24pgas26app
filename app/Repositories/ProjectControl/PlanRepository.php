<?php

namespace App\Repositories\ProjectControl;

use App\Models\ProjectControl\Plan;
use Illuminate\Support\Collection;

class PlanRepository
{
    public function __construct(protected Plan $model)
    {
    }

    public function getAllByBoqId(int $boqId): Collection
    {
        return $this->model
            ->newQuery()
            ->where('boq_id', $boqId)
            ->with([
                'unitPrice.itemDetail',
                'unitPrice.itemDetail.section',
                'unitPrice.itemDetail.category',
                'unitPrice.itemDetail.subCategory',
                'unitPrice.latestRecordPrice',])
            ->get();

    }

    public function getAllByPlanId(int $planId): Collection
    {
        return $this->model
            ->newQuery()
            ->where('id', $planId)
            ->with([
                'boq',
                'boq.project:id,price_list_id,project_name,project_code,project_number,area,start_date,end_date',
                'boq.project.priceList:id,client',
                'unitPrice:id,item_detail_id',
                'unitPrice.itemDetail:id,name,section_id,category_id,sub_category_id',
                'unitPrice.itemDetail.section:id,name',
                'unitPrice.itemDetail.category:id,name',
                'unitPrice.itemDetail.subCategory:id,name',
            ])->get();

    }

    public function findById(int $id): Plan
    {
        return $this
            ->model
            ->newQuery()
            ->findOrFail($id);
    }


    public function deleteUnselectedUnitPrices(int $boqId, array $unitPriceIds): int
    {
        $query = $this->model
            ->newQuery()
            ->where('boq_id', $boqId);

        if (empty($unitPriceIds)) {
            return $query->delete();
        }

        return $query->whereNotIn('unit_price_id', $unitPriceIds)->delete();

    }

    public function createSelectedUnitPrices(int $boqId, int $unitPriceId): Plan
    {
        return $this->model
            ->newQuery()
            ->firstOrCreate([
                'boq_id' => $boqId,
                'unit_price_id' => $unitPriceId
            ]);
    }

    public function update(Plan $plan, array $data): Plan
    {
        $plan->update($data);
        return $plan->fresh();
    }

}
