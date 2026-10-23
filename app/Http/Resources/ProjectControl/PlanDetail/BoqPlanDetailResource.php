<?php

namespace App\Http\Resources\ProjectControl\PlanDetail;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BoqPlanDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => data_get($this->resource, 'boq.id'),
            'planId' => data_get($this->resource, 'id'),
            'projectName' => data_get($this->resource, 'boq.project.project_name'),
            'projectNumber' => data_get($this->resource, 'boq.project.project_number'),
            'client' => data_get($this->resource, 'boq.project.priceList.client'),
            'area' => data_get($this->resource, 'boq.project.area'),
            'detailArea' => data_get($this->resource, 'boq.detailed_area'),
            'startDate' => data_get($this->resource, 'boq.project.start_date'),
            'endDate' => data_get($this->resource, 'boq.project.end_date'),
        ];
    }
}
