<?php

namespace App\Services;

use App\Models\Project\Projects;
use Illuminate\Support\Collection;

class DashboardService
{

    public function getProjectStatusStatistic(): Collection
    {
        return Projects::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->get()
            ->map(function ($item) {
                $color = match (strtolower($item->status)) {
                    'finished' => '#4CAF50',
                    'on progress' => '#FB8C00',
                    'cancel' => '#d60202',
                };
                return [
                    'name' => ucfirst($item->status),
                    'value' => (int)$item->total,
                    'color' => $color,
                ];
            });

    }
}
