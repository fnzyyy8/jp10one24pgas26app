<?php

namespace App\Services\ModuleService\ManPower;

use App\Models\ManPower\Worker;
use App\Repositories\ModuleRepository\ManPower\WorkerRepository;
use App\Services\SharedService\LocalStorageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Throwable;
use RuntimeException;

class WorkerService
{
    public function __construct(
        protected WorkerRepository $repository,
        protected LocalStorageService $storageService
    ) {
    }

    public function getAll(array $filters = [])
    {
        return $this->repository->getAll($filters);
    }

    public function create(array $data): Worker
    {
        return DB::transaction(function () use ($data) {
            $workScopeIds = $data['work_scope_ids'] ?? [];

            unset($data['work_scope_ids']);

            if (
                isset($data['photo'])
                && $data['photo'] instanceof UploadedFile
            ) {
                $data['photo'] = $this->storageService->upload(
                    $data['photo'],
                    'workers/photos'
                );
            }

            $worker = $this->repository->create($data);

            $worker->workScopes()->sync($workScopeIds);

            return $worker->load('workScopes');
        });
    }

    public function update(int $id, array $data): Worker
    {
        return DB::transaction(function () use ($id, $data) {
            $hasWorkScopeIds = array_key_exists(
                'work_scope_ids',
                $data
            );

            $workScopeIds = $data['work_scope_ids'] ?? [];

            unset($data['work_scope_ids']);

            // Akses model melalui method publik repository.
            $worker = $this->repository->findById($id);

            $oldPhoto = $worker->photo;
            $newPhoto = null;

            if (
                isset($data['photo'])
                && $data['photo'] instanceof UploadedFile
            ) {
                // Upload foto baru sebelum mengganti foto lama.
                $newPhoto = $this->storageService->upload(
                    $data['photo'],
                    'workers/photos'
                );

                $data['photo'] = $newPhoto;
            } else {
                // Tidak mengganti foto jika tidak ada file baru.
                unset($data['photo']);
            }

            try {
                $updatedWorker = $this->repository->update(
                    $id,
                    $data
                );

                if ($hasWorkScopeIds) {
                    $updatedWorker->workScopes()->sync(
                        $workScopeIds
                    );
                }
            } catch (Throwable $exception) {
                // Bersihkan file baru jika proses update gagal.
                if ($newPhoto !== null) {
                    try {
                        $this->storageService->delete($newPhoto);
                    } catch (Throwable $cleanupException) {
                        report($cleanupException);
                    }
                }

                throw $exception;
            }

            // Hapus foto lama setelah proses update berhasil.
            if ($newPhoto !== null && $oldPhoto) {
                try {
                    $this->storageService->delete($oldPhoto);
                } catch (Throwable $exception) {
                    // Database sudah diperbarui; catat kegagalan
                    // penghapusan file untuk ditangani kemudian.
                    report($exception);
                }
            }

            return $updatedWorker->load('workScopes');
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $worker = $this->repository->findById($id);

            $photo = $worker->photo;

            $deleted = $this->repository->delete($id);

            if ($deleted && $photo) {
                try {
                    $this->storageService->delete($photo);
                } catch (Throwable $exception) {
                    // Catat agar penghapusan file dapat ditangani.
                    report($exception);
                }
            }

            return $deleted;
        });
    }

    public function getWorkerStatusSummary(): array
    {
        return $this->repository->getWorkerStatusSummary();
    }
}
