<?php

namespace App\Http\Controllers\ProjectControl;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectControl\PlanDetail\CreatePlanDetailRequest;
use App\Http\Resources\ProjectControl\PlanDetail\BoqPlanDetailResource;
use App\Http\Resources\ProjectControl\PlanDetail\ItemDetailPlanDetailResource;
use App\Http\Resources\ProjectControl\PlanDetail\PlanDetailResources;
use App\Models\ProjectControl\Boq;
use App\Models\ProjectControl\Plan;
use App\Services\ModuleService\ProjectControl\BoqService;
use App\Services\ModuleService\ProjectControl\PlanDetailService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use InvalidArgumentException;
use Throwable;

class PlanDetailController extends Controller
{
    public function __construct(
        protected PlanDetailService $service,
        protected BoqService        $boqService
    )
    {
    }

    public function index(Boq $boq, Plan $plan)
    {
        $planDetail = $this->service->getByPlanId($plan->id);
        $boq = (new BoqPlanDetailResource($planDetail->first()))->resolve();
        $itemDetail = (new ItemDetailPlanDetailResource($planDetail->first()))->resolve();
        $planDetails = PlanDetailResources::collection($this->service->getAllByPlan($plan->id))->resolve();

        return Inertia::render('projectControl/PlanDetail/PlanDetailPage', [
            'boq' => $boq,
            'itemDetail' => $itemDetail,
            'planDetails' => $planDetails,
        ]);
    }

    public function create(CreatePlanDetailRequest $request, int $boq, int $plan): RedirectResponse
    {
        try {
            $validated = $request->validated();

            $this->service->create($validated);

            return redirect()->route('plan.detail.index', [
                'boq' => $boq,
                'plan' => $plan,
            ])->with('success', 'Data Plan berhasil ditambahkan');
        } catch (InvalidArgumentException $e) {

            return redirect()->back()->with('error', $e->getMessage());

        } catch (Throwable $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete(Boq $boq,int $id): RedirectResponse
    {
        logger()->info('Delete PlanDetail', [
            'received_id' => $id,
        ]);

        try {
            $this->service->delete($id);
            return redirect()->back()->with('success', 'Plan Detail berhasil dihapus');

        } catch (Throwable $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
