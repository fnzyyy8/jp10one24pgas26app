<?php

namespace App\Http\Resources\ProjectControl;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgressInformationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'boq_id' => data_get($this->resource, 'id'),
            'project_name' => data_get($this->resource, 'project.project_name'),
            'project_number' => data_get($this->resource, 'project.project_number'),
            'area' => data_get($this->resource, 'project.area'),
            'detailedArea' => data_get($this->resource, 'detailed_area'),
            'client' => data_get($this->resource, 'project.priceList.client'),
            'startDate' => data_get($this->resource, 'project.start_date'),
            'endDate' => data_get($this->resource, 'project.end_date'),
        ];
    }
}
