<?php

namespace App\Http\Controllers\ManPower;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManPower\CreateWorkerRequest;
use App\Http\Requests\ManPower\UpdateWorkerRequest;
use App\Http\Resources\ManPower\WorkerResource;
use App\Models\ManPower\Worker;
use App\Models\ManPower\WorkScope;
use App\Services\ModuleService\ManPower\WorkerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class WorkerController extends Controller
{
    public function __construct(
        protected WorkerService $service
    ) {
    }

    public function index(Request $request): Response
    {
        $filters = $request->only([
            'work_scope_id',
            'based',
        ]);

        $workers = $this->service->getAll($filters);

        $basedOptions = Worker::query()
            ->distinct()
            ->pluck('based')
            ->filter()
            ->values();

        return Inertia::render('manPower/Worker/WorkerPage', [
            'workers' => WorkerResource::collection($workers)->resolve(),

            'workScopes' => WorkScope::query()
                ->orderBy('name')
                ->get(['id', 'name']),

            'basedOptions' => $basedOptions,
            'filters' => $filters,
        ]);
    }

    public function followUp(int $id): RedirectResponse
    {
        try {
            $worker = $this->service->update($id, [
                'last_follow_up' => now()->toDateString(),
            ]);

            return redirect()
                ->back()
                ->with('success', 'Follow up berhasil diperbarui.');
        } catch (Throwable $e) {
            Log::error('Worker Follow Up Error', [
                'worker_id' => $id,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui tanggal follow up.');
        }
    }

    public function create(
        CreateWorkerRequest $request
    ): RedirectResponse {
        try {
            $data = $request->validated();

            if (!empty($data['last_follow_up'])) {
                $data['last_follow_up'] = date(
                    'Y-m-d',
                    strtotime($data['last_follow_up'])
                );
            }

            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo');
            }

            $this->service->create($data);

            return redirect()
                ->back()
                ->with('success', 'Worker created successfully');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Worker Create Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal membuat data worker.');
        }
    }

    public function edit(int $id): Response
    {
        $worker = Worker::with([
            'workScopes',
            'certificates',
        ])->findOrFail($id);

        $certificates = $worker->certificates
            ->sortByDesc('created_at')
            ->values()
            ->map(fn ($certificate) => [
                'id' => $certificate->id,
                'certificate_name' => $certificate->certificate_name,

                'expired_date' => $certificate->expired_date
                    ? $certificate->expired_date->format('Y-m-d')
                    : null,

                'document_type' => match (
                strtolower(
                    pathinfo(
                        $certificate->document_path ?? '',
                        PATHINFO_EXTENSION
                    )
                )
                ) {
                    'jpeg', 'jpg' => 'JPG',
                    'png' => 'PNG',
                    'webp' => 'WEBP',
                    'pdf' => 'PDF',
                    default => null,
                },

                'document_url' => $certificate->document_path
                    ? Storage::disk('public')->url(
                        $certificate->document_path
                    )
                    : null,
            ]);

        return Inertia::render('manPower/Worker/EditWorkerPage', [
            'worker' => (new WorkerResource($worker))->resolve(),

            'workScopes' => WorkScope::query()
                ->orderBy('name')
                ->get(['id', 'name']),

            'certificates' => $certificates,
        ]);
    }

    public function update(
        UpdateWorkerRequest $request,
        int $id
    ): RedirectResponse {
        try {
            $data = $request->validated();

            if (!empty($data['last_follow_up'])) {
                $data['last_follow_up'] = date(
                    'Y-m-d',
                    strtotime($data['last_follow_up'])
                );
            }

            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo');
            }

            $this->service->update($id, $data);

            return redirect()
                ->route('worker.index')
                ->with('success', 'Worker updated successfully');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Worker Update Error', [
                'worker_id' => $id,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui data worker.');
        }
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            $this->service->delete($id);

            return redirect()
                ->back()
                ->with('success', 'Worker deleted successfully');
        } catch (Throwable $e) {
            Log::error('Worker Delete Error', [
                'worker_id' => $id,
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus data worker.');
        }
    }
}
