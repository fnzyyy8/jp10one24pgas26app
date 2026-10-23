<?php

namespace App\Repositories\Project;

use App\Models\Project\Projects;
use Illuminate\Support\Collection;

class ProjectRepository
{

    public function __construct(
        protected Projects $model
    )
    {
    }

    public function getAll(): Collection
    {
        return $this->model
            ->newQuery()
            ->with([
                'priceList:id,client'
            ])
            ->latest()
            ->get();
    }

    public function findById(int $id): Projects
    {
        return $this->model->newQuery()->findOrFail($id);

    }

    public function create(array $data): Projects
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(Projects $project, array $data): Projects
    {
        $project->update($data);
        return $project->fresh();

    }

    public function delete(Projects $project): bool
    {
        return (bool)$project->delete();

    }

    public function hasBoq(Projects $project): bool
    {
        return $project->boqs()->exists();

    }
}
