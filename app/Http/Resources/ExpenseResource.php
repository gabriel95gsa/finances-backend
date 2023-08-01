<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
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
            'description' => $this->description,
            'recurrent_expense' => new RecurrentExpenseResource($this->whenLoaded('recurrentExpense')),
            'value' => $this->value,
            'period_date' => $this->period_date,
            'due_day' => $this->due_day,
        ];
    }
}
