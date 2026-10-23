<?php

namespace App\Services\ModuleService\ManPower;

use App\Repositories\ModuleRepository\ManPower\WorkScopeRepository;
use Illuminate\Support\Facades\DB;
use Throwable;
use RuntimeException;

class WorkScopeService
{
    public function __construct(protected WorkScopeRepository $repository)
    {
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $workScope = $this->repository->create($data);
            DB::commit();
            return $workScope;
        } catch (Throwable $e) {
            DB::rollBack();
            throw new RuntimeException('Failed to create work scope: ' . $e->getMessage(), previous: $e);
        }
    }

    public function update(int $id, array $data)
    {
        DB::beginTransaction();
        try {
            $workScope = $this->repository->update($id, $data);
            DB::commit();
            return $workScope;
        } catch (Throwable $e) {
            DB::rollBack();
            throw new RuntimeException('Failed to update work scope: ' . $e->getMessage(), previous: $e);
        }
    }

    public function delete(int $id)
    {
        DB::beginTransaction();
        try {
            $result = $this->repository->delete($id);
            DB::commit();
            return $result;
        } catch (Throwable $e) {
            DB::rollBack();
            throw new RuntimeException('Failed to delete work scope: ' . $e->getMessage(), previous: $e);
        }
    }
}
