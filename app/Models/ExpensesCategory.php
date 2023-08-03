<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpensesCategory extends Model
{
    use HasFactory;

    protected $table = 'expenses_categories';

    protected $fillable = ['user_id', 'name'];

    /**
     * @return HasMany
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * @return HasMany
     */
    public function recurrentExpenses(): HasMany
    {
        return $this->hasMany(RecurrentExpense::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
