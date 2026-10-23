<?php

namespace App\Repositories\ModuleRepository\ManPower;

use App\Models\ManPower\WorkScope;
use Illuminate\Database\Eloquent\Collection;

class WorkScopeRepository
{
    public function __construct(
        protected WorkScope $model
    ) {
    }

    public function getAll(): Collection
    {
        return $this->model
            ->latest()
            ->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $workScope = $this->model->findOrFail($id);
        $workScope->update($data);

        return $workScope;
    }

    public function delete(int $id)
    {
        $workScope = $this->model->findOrFail($id);

        return $workScope->delete();
    }


}
