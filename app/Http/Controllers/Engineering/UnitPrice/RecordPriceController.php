<?php

namespace App\Http\Controllers\Engineering\UnitPrice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Engineering\RecordPrice\CreateRecordPriceRequest;
use App\Http\Resources\Engineering\RecordPrice\RecordPriceUnitPriceResource;
use App\Services\ModuleService\Engineering\PriceListService;
use App\Services\ModuleService\Engineering\RecordPriceService;
use App\Services\ModuleService\Engineering\UnitPriceService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class RecordPriceController extends Controller
{
    public function __construct(
        protected RecordPriceService $service,
        protected PriceListService   $priceListService,
        protected UnitPriceService   $unitPriceService
    )
    {
    }

    public function index(int $priceListId, int $id): Response
    {
        $priceList = $this->priceListService->getPriceById($priceListId);
        $unitPrice = $this->unitPriceService->getUnitPrice($id);

        $recordPrices = $this->service->getByUnitPriceId($id);

        return Inertia::render('Engineering/RecordPrice/RecordPricePage', [
            'priceList' => $priceList,
            'recordPrices' => $recordPrices,
            'unitPrice' => (new RecordPriceUnitPriceResource($unitPrice))->resolve(),
        ]);
    }

    public function create(CreateRecordPriceRequest $request,int $priceListId): RedirectResponse
    {
        $data = $request->validated();
        $this->service->create($data);

        return redirect()->back()->with('success', 'success create record price');
    }

    public function delete(int $priceListId, int $id): RedirectResponse
    {
        $this->service->delete($id);
        return redirect()->back()->with('info', 'success delete record price');
    }

}
