<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncomeResource extends JsonResource
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
            'recurrent_income' => new RecurrentIncomeResource($this->whenLoaded('recurrentIncome')),
            'value' => $this->value,
            'period_date' => $this->period_date,
        ];
    }
}
