<?php

namespace App\Http\Controllers\ManPower;

use App\Http\Controllers\Controller;
use App\Models\ManPower\Worker;
use App\Services\ModuleService\ManPower\WorkerCertificateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class WorkerCertificateController extends Controller
{
    public function __construct(
        protected WorkerCertificateService $service
    ) {}

    public function store(
        Request $request,
        int $workerId
    ): RedirectResponse {
        $validated = $request->validate([
            'certificate_name' => ['required', 'string', 'max:255'],
            'expired_date' => ['nullable', 'date'],
            'document' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,webp,pdf',
                'max:10240',
            ],
        ]);

        try {
            $worker = Worker::findOrFail($workerId);

            $this->service->create($worker, $validated);

            return back()->with(
                'success',
                'Sertifikat berhasil ditambahkan.'
            );
        } catch (Throwable $exception) {
            Log::error('Worker Certificate Create Error', [
                'worker_id' => $workerId,
                'message' => $exception->getMessage(),
            ]);

            return back()->with(
                'error',
                'Gagal menyimpan sertifikat.'
            );
        }
    }

    public function delete(
        int $workerId,
        int $certificateId
    ): RedirectResponse {
        try {
            $worker = Worker::findOrFail($workerId);

            $this->service->delete($worker, $certificateId);

            return back()->with(
                'success',
                'Sertifikat berhasil dihapus.'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            abort(404);
        } catch (Throwable $exception) {
            Log::error('Worker Certificate Delete Error', [
                'worker_id' => $workerId,
                'certificate_id' => $certificateId,
                'message' => $exception->getMessage(),
            ]);

            return back()->with(
                'error',
                'Gagal menghapus sertifikat.'
            );
        }
    }
}
