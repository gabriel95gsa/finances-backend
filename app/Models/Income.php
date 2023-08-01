<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'recurrent_income_id', 'value', 'period_date'];

    public function recurrentIncome()
    {
        return $this->belongsTo(RecurrentIncome::class);
    }
}
