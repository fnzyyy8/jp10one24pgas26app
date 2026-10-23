<?php

namespace App\Http\Controllers\Engineering;

use App\Http\Controllers\Controller;
use App\Http\Requests\Engineering\ItemDetail\CreateItemDetailRequest;
use App\Http\Requests\Engineering\ItemDetail\UpdateItemDetailRequest;
use App\Services\ModuleService\Engineering\ItemDetailService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class ItemDetailController extends Controller
{
    public function __construct(
        protected ItemDetailService $service
    )
    {
    }

    public function index()
    {
        return Inertia::render('Engineering/ItemDetail/ItemDetailPage', [
            'itemDetailOptions' => $this->service->getItemDetailOptions(),
            'itemDetails' => $this->service->getAll()
        ]);
    }

    public function create(CreateItemDetailRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());
        return to_route('item-details.index')
            ->with('success', 'Item detail created successfully.');
    }

    public function update(int $id, UpdateItemDetailRequest $request): RedirectResponse
    {
        $this->service->update($id, $request->validated());
        return redirect()->route('item-details.index')->with('success', 'Item detail updated successfully.');

    }

    public function delete(int $id): RedirectResponse
    {
        $this->service->delete($id);
        return redirect()->route('item-details.index')->with('info', 'Berhasil Menghapus Item detail.');
    }

}
