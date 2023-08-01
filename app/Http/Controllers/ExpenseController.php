<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Models\RecurrentExpense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
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

        return ExpenseResource::collection($expenses->load('recurrentExpense'));
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
            $recurrentIncome = RecurrentExpense::where('id', $validated['recurrent_expense_id'])->first();

            $validated['description'] = $recurrentIncome->description;
            $validated['value'] = $recurrentIncome->default_value;
            $validated['due_day'] = $recurrentIncome->due_day;
        }

        $expense = Expense::create($validated);

        return response()->json($expense);
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

        return new ExpenseResource($expense->load('recurrentExpense'));
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
}
