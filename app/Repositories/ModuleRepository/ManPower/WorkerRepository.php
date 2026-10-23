<?php

namespace App\Repositories\ModuleRepository\ManPower;

use App\Models\ManPower\Worker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class WorkerRepository
{
    public function __construct(
        protected Worker $model
    ) {
    }

    public function getAll(array $filters = []): Collection
    {
        $query = $this->model
            ->with('workScopes')
            ->latest();

        if (!empty($filters['work_scope_id'])) {
            $query->whereHas('workScopes', function ($query) use ($filters) {
                $query->where(
                    'work_scopes.id',
                    $filters['work_scope_id']
                );
            });
        }

        if (!empty($filters['based'])) {
            $query->where('based', $filters['based']);
        }

        return $query->get();
    }

    public function create(array $data): Worker
    {
        return $this->model->create($data);
    }

    public function findById(int $id): Worker
    {
        return $this->model->findOrFail($id);
    }

    public function update(int $id, array $data): Worker
    {
        $worker = $this->findById($id);
        $worker->update($data);

        return $worker->refresh();
    }

    public function delete(int $id): bool
    {
        $worker = $this->findById($id);

        return (bool) $worker->delete();
    }

    public function getWorkerStatusSummary(): array
    {
        $result = Worker::query()
            ->select('work_status', DB::raw('COUNT(*) as total'))
            ->groupBy('work_status')
            ->pluck('total', 'work_status');

        return [
            'active_workers' => (int) ($result['active'] ?? 0),
            'non_active_workers' => (int) ($result['not active'] ?? 0),
            'on_work_workers' => (int) ($result['on work'] ?? 0),
        ];
    }
}
