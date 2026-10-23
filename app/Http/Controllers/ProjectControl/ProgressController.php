<?php

namespace App\Http\Controllers\ProjectControl;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectControl\ProgressInformationResource;
use App\Models\ProjectControl\Boq;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProgressController extends Controller
{
    public function index(Boq $boq): Response
    {
        $boq = $boq->load('project.priceList');
        $boqResource = (new ProgressInformationResource($boq))->resolve();

        return Inertia::render('projectControl/Progress/ProgressPage', [
            'boq' => $boqResource,
        ]);
    }
}
