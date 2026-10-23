<?php

namespace App\Http\Controllers\Engineering\UnitPrice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Engineering\UnitPrice\SyncUnitPriceRequest;
use App\Http\Resources\Engineering\UnitPrice\UnitPriceResource;
use App\Models\Engineering\PriceList\PriceList;
use App\Services\ModuleService\Engineering\ItemDetailService;
use App\Services\ModuleService\Engineering\UnitPriceService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class UnitPriceController extends Controller
{
    public function __construct(
        protected UnitPriceService  $service,
        protected ItemDetailService $itemDetailService
    )
    {
    }

    public function index(PriceList $priceList): Response
    {

        $itemDetails = $this->itemDetailService->getAll();

        return Inertia::render('Engineering/UnitPrice/UnitPricePage',
            [
                'priceList' => $priceList,
                'unitPrice' => $this->service->getPriceByPriceListId($priceList->id),
                'sections' => UnitPriceResource::collection($itemDetails)->resolve(),
            ]);
    }

    public function sync(SyncUnitPriceRequest $request, PriceList $priceList): RedirectResponse
    {
        $this->service->sync(
            $priceList->id,
            $request->validated('item_detail_ids')
        );

        return redirect()
            ->back()
            ->with('success', 'Unit prices synchronized successfully.');

    }
}
