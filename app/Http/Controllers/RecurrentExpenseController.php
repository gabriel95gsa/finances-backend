<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecurrentExpenseRequest;
use App\Http\Requests\UpdateRecurrentExpenseRequest;
use App\Http\Resources\RecurrentExpenseResource;
use App\Models\RecurrentExpense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class RecurrentExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        return RecurrentExpenseResource::collection(RecurrentExpense::all());
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

        return response()->json($recurrentExpense);
    }

    /**
     * Display the specified resource.
     *
     * @param RecurrentExpense $recurrentExpense
     * @return JsonResource
     */
    public function show(RecurrentExpense $recurrentExpense): JsonResource
    {
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
        $recurrentExpense->delete();

        return response()->json([
            'message' => 'Record deleted.'
        ]);
    }
}
