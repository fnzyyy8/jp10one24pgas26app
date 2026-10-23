<?php

namespace App\Http\Resources\Project;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'price_list_id' => $this->price_list_id,
            'status' => $this->status,
            'project_name' => $this->project_name,
            'project_number' => $this->project_number,
            'project_code' => $this->project_code,
            'budget' => $this->budget,
            'area' => $this->area,
            'client' => $this->priceList->client,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,

        ];
    }
}
