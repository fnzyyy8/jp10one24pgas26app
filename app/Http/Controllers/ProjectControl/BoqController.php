<?php

namespace App\Http\Controllers\ProjectControl;

use App\Exceptions\ProjectControl\BoqHasPlanException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectControl\Boq\CreateBoqRequest;
use App\Http\Requests\ProjectControl\Boq\UpdateBoqRequest;
use App\Services\ModuleService\ProjectControl\BoqService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class BoqController extends Controller
{
    public function __construct(
        protected BoqService $service
    )
    {
    }

    public function index(Request $request): Response
    {
        $selectedCategory = $request->input('category');
        $selectedProject = $request->input('projectId');

        $formBoqOptions = $this->service
            ->formBoqOptions($selectedCategory);

        $boqs = $this->service->getAll();

        return Inertia::render('projectControl/Boq/BoqPage',
            [

                'boqs' => $boqs,
                'formBoqOptions' => $formBoqOptions,

                'filters' => [
                    'category' => $selectedCategory,
                    'projectId' => $selectedProject
                ]

            ]);
    }

    public function create(
        CreateBoqRequest $request
    ): RedirectResponse
    {
        $this->service->create(
            $request->validated()
        );

        return redirect()
            ->back()
            ->with(
                'success',
                'Success Create Boq'
            );

    }

    public function update(UpdateBoqRequest $request, int $id): RedirectResponse
    {
        $this->service->update(
            $id,
            $request->validated()
        );

        return redirect()
            ->back()
            ->with(
                'success',
                'Success Update Boq'
            );

    }

    public function delete(int $id): RedirectResponse
    {
        try {
            $this->service->delete($id);

            return redirect()
                ->back()
                ->with('success', 'Success Delete Boq');

        } catch (BoqHasPlanException $e) {

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        } catch (Throwable $e) {

            return redirect()
                ->back()
                ->with('error', 'Terjadi Kesalahan saat menghapus Boq');
        }
    }
}
