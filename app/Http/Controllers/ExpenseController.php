<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Models\RecurrentExpense;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $expenses = Expense::where('user_id', auth()->user()->id)->get();

        return ExpenseResource::collection($expenses->load(['expensesCategory', 'recurrentExpense']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreExpenseRequest $request
     * @return JsonResponse
     */
    public function store(StoreExpenseRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($request->safe()->has('recurrent_expense_id') && $validated['recurrent_expense_id']) {
            $recurrentExpense = RecurrentExpense::where('id', $validated['recurrent_expense_id'])->first();

            $validated['expenses_category_id'] = $recurrentExpense->expenses_category_id;
            $validated['description'] = $recurrentExpense->description;
            $validated['value'] = $validated['value'] ?? $recurrentExpense->default_value;
            $validated['due_day'] = $recurrentExpense->due_day;
        }

        $expense = Expense::create($validated);

        return response()->json($expense, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Expense $expense
     * @return JsonResource
     */
    public function show(Expense $expense): JsonResource
    {
        $this->authorize('view', $expense);

        return new ExpenseResource($expense->load(['expensesCategory', 'recurrentExpense']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateExpenseRequest $request
     * @param Expense $expense
     * @return JsonResponse
     */
    public function update(UpdateExpenseRequest $request, Expense $expense): JsonResponse
    {
        $this->authorize('update', $expense);

        // Assuring the recurrent expense won`t be altered
        $validated = $request->safe()->except(['recurrent_expense_id']);

        $expense->update($validated);

        return response()->json($expense);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Expense $expense
     * @return JsonResponse
     */
    public function destroy(Expense $expense): JsonResponse
    {
        $this->authorize('delete', $expense);

        $expense->delete();

        return response()->json(['message' => 'Record deleted.']);
    }

    /**
     * List all expenses (joining expenses and recurrent_expenses) by period (ex.: 2023-05)
     *
     * @param string|null $period
     * @return JsonResponse
     */
    public function listAllExpensesByPeriod(?string $period = null): JsonResponse
    {
        $currentMonth = $period ?? Carbon::now()->format('Y-m');
        $userId = auth()->user()->id;

        /*
         * For this query, only rows from recurrent_expenses table
         * will have recurrent_expense_id value and
         * only rows from expenses table will have expense_id value
         */
        $expensesQuery = DB::table('expenses')
            ->select(
                DB::raw("id as expense_id"),
                'description',
                'value', 'period_date',
                'due_day',
                'expenses_category_id',
                DB::raw("NULL as recurrent_expense_id"),
            )
            ->where('user_id', $userId)
            ->where('period_date', $currentMonth);

        $expenses = DB::table('recurrent_expenses')
            ->select(
                DB::raw("NULL as expense_id"),
                'description',
                'default_value as value',
                DB::raw("$currentMonth as period_date"),
                'due_day',
                'expenses_category_id',
                DB::raw("id as recurrent_expense_id"),
            )
            ->where('user_id', $userId)
            ->where('status', 1)
            ->where(
                'created_at',
                '<=',
                Carbon::createFromFormat('Y-m-d', "{$currentMonth}-01")->endOfMonth()
            )
            ->whereNotIn('id', function (Builder $query) use ($currentMonth, $userId) {
                $query->select('recurrent_expense_id')
                    ->from('expenses')
                    ->where('expenses.user_id', $userId)
                    ->where('expenses.period_date', $currentMonth)
                    ->whereNotNull('recurrent_expense_id');
            })
            ->union($expensesQuery)
            ->get();

        return response()->json($expenses);
    }
}
