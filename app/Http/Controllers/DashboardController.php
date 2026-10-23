<?php

namespace App\Http\Controllers;

use App\Services\ModuleService\Dashboard\DashboardService;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function show(DashboardService $dashboardService)
    {
        return Inertia::render('Dashboard', [
            'page_title' => 'Dashboard',
            'project_statuses' => $dashboardService->getProjectStatusStatistic()
        ]);

    }
}
