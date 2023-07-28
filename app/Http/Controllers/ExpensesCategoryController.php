<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpensesCategoryRequest;
use App\Http\Requests\UpdateExpensesCategoryRequest;
use App\Http\Resources\ExpensesCategoryResource;
use App\Models\ExpensesCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpensesCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        return ExpensesCategoryResource::collection(ExpensesCategory::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreExpensesCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreExpensesCategoryRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $expenseCategory = ExpensesCategory::create($validated);

        return response()->json($expenseCategory);
    }

    /**
     * Display the specified resource.
     *
     * @param ExpensesCategory $expensesCategory
     * @return JsonResource
     */
    public function show(ExpensesCategory $expensesCategory): JsonResource
    {
        return new ExpensesCategoryResource($expensesCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateExpensesCategoryRequest $request
     * @param ExpensesCategory $expensesCategory
     * @return JsonResponse
     */
    public function update(UpdateExpensesCategoryRequest $request, ExpensesCategory $expensesCategory): JsonResponse
    {
        $validated = $request->validated();

        $expensesCategory->update($validated);

        return response()->json($expensesCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ExpensesCategory $expensesCategory
     * @return JsonResponse
     */
    public function destroy(ExpensesCategory $expensesCategory): JsonResponse
    {
        $expensesCategory->delete();

        return response()->json([
            'message' => 'Record deleted.'
        ]);
    }
}
