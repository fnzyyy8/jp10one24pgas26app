<?php

namespace App\Services\Project;

use App\Exceptions\Project\ProjectHasBoqException;
use App\Models\Project\Projects;
use App\Repositories\Project\ProjectRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use RuntimeException;

/**
 * @throws ProjectHasBoqException
 * @throws RuntimeException
 */
class ProjectService
{

    public function __construct(
        protected ProjectRepository $repository,
    )
    {
    }

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    public function create($data): Projects
    {
        try {
            return DB::transaction(function () use ($data) {
                return $this->repository->create($data);
            });

        } catch (Throwable $e) {

            Log::error('Failed to create project. ', [
                'message' => $e->getMessage(),
                'data' => $data
            ]);

            throw new RuntimeException(
                'Failed to create project.',
                previous: $e
            );
        }
    }

    public function update(int $id, array $data): Projects
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $project = $this->repository->findById($id);

                return $this->repository->update(
                    $project,
                    $data
                );
            });
        } catch (Throwable $e) {
            Log::error('Failed to update project: ', [
                'project_id' => $id,
                'message' => $e->getMessage(),
                'data' => $data
            ]);
            throw new RuntimeException(
                'Failed to update project.',
                previous: $e
            );
        }
    }

    /**
     * @throws ProjectHasBoqException
     * @throws RuntimeException
     */
    public function delete(int $id): void
    {
        try {
            DB::transaction(function () use ($id) {

                $project = $this->repository->findById($id);

                if ($this->repository->hasBoq($project)) {
                    throw new ProjectHasBoqException();
                }

                $this->repository->delete($project);
            });

        } catch (ProjectHasBoqException $e) {

            Log::warning('Project Deletion blocked.', [
                'project_id' => $id,
                'message' => $e->getMessage()
            ]);

            throw $e;

        } catch (Throwable $e) {

            Log::error('Failed to delete project: ', [
                'project_id' => $id,
                'message' => $e->getMessage(),
            ]);

            throw new RuntimeException(
                'Failed to delete project.',
                previous: $e
            );
        }

    }

}
