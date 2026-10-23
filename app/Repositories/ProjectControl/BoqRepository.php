<?php

namespace App\Repositories\ProjectControl;

use App\Models\Project\Projects;
use App\Models\ProjectControl\Boq;
use Illuminate\Support\Collection;

class BoqRepository
{

    public function __construct(
        protected Boq $model
    )
    {
    }

    public function getAll(): Collection
    {
        return $this->model
            ->newQuery()
            ->with(['plans.unitPrice.latestRecordPrice'])
            ->join(
                "projects",
                "boqs.project_id", "=", "projects.id")
            ->select([
                "projects.project_number as project_number",
                "projects.project_code as project_code",
                "projects.project_name as project_name",
                "projects.area as project_area",
                "projects.budget as project_budget",

                'boqs.id',
                'boqs.project_id',
                'boqs.detailed_area',
                'boqs.isMultipleCustomer',
            ])
            ->latest('boqs.created_at')
            ->get();
    }

    public function findById(int $id): Boq
    {
        return $this->model
            ->newQuery()
            ->findOrFail($id);

    }

    public function create(array $data): Boq
    {
        return $this->model
            ->newQuery()
            ->create($data);
    }

    public function update(Boq $boq, array $data): Boq
    {
        $boq->update($data);

        return $boq->fresh();

    }

    public function delete(Boq $boq): bool
    {
        return (bool)$boq->delete();
    }


    public function getProjectForBoq(): Collection
    {
        return Projects::query()
            ->select([
                'id',
                'project_name',
                'category',
                'isMultipleArea',
            ])
            ->where(function ($query) {
                $query
                    ->where('isMultipleArea', true)
                    ->orWhere(function ($query) {
                        $query
                            ->where('isMultipleArea', false)
                            ->whereDoesntHave('boqs');
                    });
            })
            ->get()
            ->values();
    }

}
