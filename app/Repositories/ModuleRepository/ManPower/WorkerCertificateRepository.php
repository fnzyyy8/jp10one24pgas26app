<?php

namespace App\Repositories\ModuleRepository\ManPower;

use App\Models\ManPower\Worker;
use App\Models\ManPower\WorkerCertificate;
use Illuminate\Database\Eloquent\Collection;

class WorkerCertificateRepository
{
    public function getByWorker(Worker $worker): Collection
    {
        return $worker->certificates()
            ->latest()
            ->get();
    }

    public function create(
        Worker $worker,
        array $data
    ): WorkerCertificate {
        $certificate = new WorkerCertificate($data);

        $worker->certificates()->save($certificate);

        return $certificate;
    }

    public function findByWorker(
        Worker $worker,
        int $certificateId
    ): WorkerCertificate {
        /** @var WorkerCertificate $certificate */
        $certificate = $worker->certificates()
            ->whereKey($certificateId)
            ->firstOrFail();

        return $certificate;
    }

    public function delete(WorkerCertificate $certificate): bool
    {
        return (bool) $certificate->delete();
    }
}
