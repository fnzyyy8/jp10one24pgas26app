<?php

namespace App\Http\Controllers\Project;

use App\Exceptions\Project\ProjectHasBoqException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Services\ModuleService\Engineering\PriceListService;
use App\Services\ModuleService\Project\ProjectService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectService   $service,
        protected PriceListService $priceListService
    )
    {
    }

    public function index(): Response
    {

        $projects = $this->service->getAll();


        return Inertia::render('projects/ProjectPage', [
            'projects' => ProjectResource::collection($projects)->resolve(),
            'priceListOptions' => $this->priceListService->getAll(),
        ]);
    }

    public function create(CreateProjectRequest $request)
    {

        $this->service->create($request->validated());

        return redirect()
            ->back()
            ->with('success', 'Project created successfully');

    }

    public function update(UpdateProjectRequest $request, int $id): RedirectResponse
    {

        $this->service->update(
            $id,
            $request->validated()
        );

        return redirect()
            ->back()
            ->with('success', 'Project updated successfully');
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);

            return redirect()
                ->back()
                ->with(
                    'success',
                    'Project deleted successfully'
                );
        } catch (ProjectHasBoqException $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        } catch (Throwable $e) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }
}
