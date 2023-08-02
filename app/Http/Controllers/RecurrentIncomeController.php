<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecurrentIncomeRequest;
use App\Http\Requests\UpdateRecurrentIncomeRequest;
use App\Http\Resources\RecurrentIncomeResource;
use App\Models\RecurrentIncome;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class RecurrentIncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $recurrentIncomes = RecurrentIncome::where('user_id', auth()->user()->id)->get();

        return RecurrentIncomeResource::collection($recurrentIncomes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRecurrentIncomeRequest $request
     * @return JsonResponse
     */
    public function store(StoreRecurrentIncomeRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $recurrentIncome = RecurrentIncome::create($validated);

        return response()->json($recurrentIncome);
    }

    /**
     * Display the specified resource.
     *
     * @param RecurrentIncome $recurrentIncome
     * @return RecurrentIncomeResource
     */
    public function show(RecurrentIncome $recurrentIncome): JsonResource
    {
        $this->authorize('view', $recurrentIncome);

        return new RecurrentIncomeResource($recurrentIncome);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRecurrentIncomeRequest $request
     * @param RecurrentIncome $recurrentIncome
     * @return JsonResponse
     */
    public function update(UpdateRecurrentIncomeRequest $request, RecurrentIncome $recurrentIncome): JsonResponse
    {
        $this->authorize('update', $recurrentIncome);

        $validated = $request->validated();

        $recurrentIncome->update($validated);

        return response()->json($recurrentIncome);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RecurrentIncome $recurrentIncome
     * @return JsonResponse
     */
    public function destroy(RecurrentIncome $recurrentIncome): JsonResponse
    {
        $this->authorize('delete', $recurrentIncome);

        $recurrentIncome->delete();

        return response()->json([
            'message' => 'Record deleted.'
        ]);
    }
}
