<?php

namespace App\Http\Resources\ProjectControl\ItemDetail;

use App\Models\Engineering\ItemDetail\ItemDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemDetailTableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @mixin ItemDetail
         */
        return [
            'id' => $this->id,

            'section_id' => $this->section_id,
            'category_id' => $this->category_id,
            'sub_category_id' => $this->sub_category_id,

            'name' => $this->name,
            'unit' => $this->unit,
            'sort_order' => $this->sort_order,

            'section' => $this->section
                ? [
                    'id' => $this->section->id,
                    'name' => $this->section->name,
                    'sort_order' => $this->section->sort_order,
                ]
                : null,

            'category' => $this->category
                ? [
                    'id' => $this->category->id,
                    'section_id' => $this->category->section_id,
                    'name' => $this->category->name,
                    'sort_order' => $this->category->sort_order,
                ]
                : null,

            'sub_category' => $this->subCategory
                ? [
                    'id' => $this->subCategory->id,
                    'category_id' => $this->subCategory->category_id,
                    'name' => $this->subCategory->name,
                    'sort_order' => $this->subCategory->sort_order,
                ]
                : null,
        ];
    }

}
