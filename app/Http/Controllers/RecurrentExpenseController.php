<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecurrentExpenseRequest;
use App\Http\Requests\UpdateRecurrentExpenseRequest;
use App\Http\Resources\RecurrentExpenseResource;
use App\Models\RecurrentExpense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class RecurrentExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $recurrentExpenses = RecurrentExpense::where('user_id', auth()->user()->id)->get();

        return RecurrentExpenseResource::collection($recurrentExpenses->load('expensesCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRecurrentExpenseRequest $request
     * @return JsonResponse
     */
    public function store(StoreRecurrentExpenseRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $recurrentExpense = RecurrentExpense::create($validated);

        return response()->json($recurrentExpense, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param RecurrentExpense $recurrentExpense
     * @return JsonResource
     */
    public function show(RecurrentExpense $recurrentExpense): JsonResource
    {
        $this->authorize('view', $recurrentExpense);

        return new RecurrentExpenseResource($recurrentExpense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRecurrentExpenseRequest $request
     * @param RecurrentExpense $recurrentExpense
     * @return JsonResponse
     */
    public function update(UpdateRecurrentExpenseRequest $request, RecurrentExpense $recurrentExpense): JsonResponse
    {
        $this->authorize('update', $recurrentExpense);

        $validated = $request->validated();

        $recurrentExpense->update($validated);

        return response()->json($recurrentExpense);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RecurrentExpense $recurrentExpense
     * @return JsonResponse
     */
    public function destroy(RecurrentExpense $recurrentExpense): JsonResponse
    {
        $this->authorize('delete', $recurrentExpense);

        $recurrentExpense->delete();

        return response()->json([
            'message' => 'Record deleted.'
        ]);
    }
}
