<?php

namespace App\Services\ModuleService\ManPower;

use App\Models\ManPower\Worker;
use App\Models\ManPower\WorkerCertificate;
use App\Repositories\ModuleRepository\ManPower\WorkerCertificateRepository;
use App\Services\SharedService\LocalStorageService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Throwable;

class WorkerCertificateService
{
    public function __construct(
        protected WorkerCertificateRepository $repository,
        protected LocalStorageService $storageService,
    ) {}

    public function getByWorker(Worker $worker): Collection
    {
        return $this->repository->getByWorker($worker);
    }

    public function create(
        Worker $worker,
        array $data
    ): WorkerCertificate {
        $document = $data['document'] ?? null;

        unset($data['document']);

        if (!$document instanceof UploadedFile) {
            throw new RuntimeException(
                'Dokumen sertifikat wajib diunggah.'
            );
        }

        $path = $this->storageService->upload(
            $document,
            'workers/certificates',
        );

        try {
            return DB::transaction(
                fn () => $this->repository->create($worker, [
                    'certificate_name' => $data['certificate_name'],
                    'expired_date' => $data['expired_date'] ?? null,
                    'document_path' => $path,
                ])
            );
        } catch (Throwable $exception) {
            $this->storageService->delete($path);

            throw $exception;
        }
    }

    public function delete(
        Worker $worker,
        int $certificateId
    ): void {
        $certificate = $this->repository->findByWorker(
            $worker,
            $certificateId,
        );

        $path = $certificate->document_path;

        DB::transaction(function () use ($certificate) {
            $this->repository->delete($certificate);
        });

        if (!$path) {
            return;
        }

        try {
            if (!$this->storageService->delete($path)) {
                report(new RuntimeException(
                    "Gagal menghapus dokumen sertifikat: {$path}"
                ));
            }
        } catch (Throwable $exception) {
            report($exception);
        }
    }
}
