<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'expenses_category_id', 'description', 'recurrent_expense_id', 'value', 'period_date', 'due_day'];

    /**
     * @return BelongsTo
     */
    public function expensesCategory(): BelongsTo
    {
        return $this->belongsTo(ExpensesCategory::class);
    }

    /**
     * @return BelongsTo
     */
    public function recurrentExpense(): BelongsTo
    {
        return $this->belongsTo(RecurrentExpense::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
