<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecurrentExpenseResource extends JsonResource
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
            'expenses_category' => new ExpensesCategoryResource($this->whenLoaded($this->expenses_category_id)),
            'description' => $this->description,
            'default_value' => $this->default_value,
            'limit_value' => $this->limit_value,
            'due_day' => $this->due_day,
            'status' => $this->status,
        ];
    }
}
