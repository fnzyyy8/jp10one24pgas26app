<?php

namespace App\Http\Resources\ProjectControl\Plan;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanBoqInformationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'price_list_id' => $this->project->price_list_id,
            'project_name' => $this->project->project_name,
            'project_number' => $this->project->project_number,
            'client' => $this->project->priceList->client,
            'area' => $this->project->area,
            'detailed_area' => $this->detailed_area,
            'startDate' => $this->project->start_date,
            'endDate' => $this->project->end_date,
        ];
    }
}
