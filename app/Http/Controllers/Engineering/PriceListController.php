<?php

namespace App\Http\Controllers\Engineering;

use App\Http\Controllers\Controller;
use App\Http\Requests\Engineering\PriceList\CreatePriceListRequest;
use App\Http\Requests\Engineering\PriceList\UpdatePriceListRequest;
use App\Http\Resources\Engineering\PriceList\PriceListDetailResource;
use App\Http\Resources\Engineering\PriceList\PriceListResource;
use App\Services\ModuleService\Engineering\ItemDetailService;
use App\Services\ModuleService\Engineering\PriceListService;
use App\Services\ModuleService\Engineering\UnitPriceService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PriceListController extends Controller
{
    public function __construct(
        protected PriceListService  $priceListService,
        protected ItemDetailService $itemDetailService,
        protected UnitPriceService  $unitPriceService
    )
    {
    }

    public function index(): Response
    {
        return Inertia::render('Engineering/PriceList/PriceListPage',
            [
                'priceLists' => $this->priceListService->getAll()
            ]
        );
    }

    public function show(int $id): Response
    {
        $unitPrice = $this->unitPriceService->getGroupByPriceListId($id);
        $priceList = $this->priceListService->getDetailWithPrices($id);

        return Inertia::render('Engineering/PriceListDetail/PriceListDetailPage', [
            'priceList' => (new PriceListDetailResource($priceList))->resolve(),
            'sections' => PriceListResource::collection($unitPrice)->resolve(),
        ]);

    }

    public function create(CreatePriceListRequest $request): RedirectResponse
    {
        $this->priceListService->create($request->validated());

        return redirect()->back()->with('success', 'Berhasil Membuat Kelompok Harga Satuan');
    }

    public function update(int $id, UpdatePriceListRequest $request): RedirectResponse
    {
        $this->priceListService->update($id, $request->validated());

        return redirect()->route('price-list.index')->with('success', 'Berhasil Mengubah Kelompok Harga Satuan');
    }

    public function delete(int $id): RedirectResponse
    {
        $this->priceListService->delete($id);

        return redirect()->route('price-list.index')->with('info', 'Berhasil Menghapus Kelompok Harga Satuan');
    }


}
