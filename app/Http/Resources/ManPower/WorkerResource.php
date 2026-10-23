<?php

namespace App\Http\Resources\ManPower;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'id_card_number' => $this->id_card_number,
            'name' => $this->name,
            'based' => $this->based,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'photo' => $this->photo,
            'photo_url' => $this->photo ? \Illuminate\Support\Facades\Storage::url($this->photo) : null,
            'work_status' => $this->work_status,
            'last_follow_up' => $this->last_follow_up,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'work_scopes' => $this->whenLoaded(
                'workScopes',
                fn() => $this->workScopes->map(fn($scope) => [
                    'id' => $scope->id,
                    'name' => $scope->name,
                ])->values())
        ];
    }
}
