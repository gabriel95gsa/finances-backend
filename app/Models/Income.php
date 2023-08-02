<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'description', 'recurrent_income_id', 'value', 'period_date'];

    /**
     * @return BelongsTo
     */
    public function recurrentIncome(): BelongsTo
    {
        return $this->belongsTo(RecurrentIncome::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
