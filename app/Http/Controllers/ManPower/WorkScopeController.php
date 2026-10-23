<?php

namespace App\Http\Controllers\ManPower;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManPower\CreateWorkScopeRequest;
use App\Http\Requests\ManPower\UpdateWorkScopeRequest;
use App\Http\Resources\ManPower\WorkScopeResource;
use App\Services\ModuleService\ManPower\WorkerService;
use App\Services\ModuleService\ManPower\WorkScopeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class WorkScopeController extends Controller
{
    public function __construct(
        protected WorkScopeService $service,
        protected WorkerService    $workerService
    )
    {
    }

    public function index(): Response
    {
        $workScopes = $this->service->getAll();

        return Inertia::render('manPower/WorkScope/WorkScopePage', [
            'workScopes' => WorkScopeResource::collection($workScopes)->resolve(),
            'workerSummary' => $this->workerService->getWorkerStatusSummary()

        ]);
    }

    public function create(CreateWorkScopeRequest $request): RedirectResponse
    {
        try {
            $this->service->create($request->validated());

            return redirect()
                ->back()
                ->with('success', 'Work Scope created successfully');
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    public function update(UpdateWorkScopeRequest $request, int $id): RedirectResponse
    {
        try {
            $this->service->update($id, $request->validated());

            return redirect()
                ->back()
                ->with('success', 'Work Scope updated successfully');
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            $this->service->delete($id);

            return redirect()
                ->back()
                ->with('success', 'Work Scope deleted successfully');
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
}
