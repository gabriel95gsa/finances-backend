<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Http\Resources\IncomeResource;
use App\Models\Income;
use App\Models\RecurrentIncome;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        $incomes = Income::where('user_id', auth()->user()->id)->get();

        return IncomeResource::collection($incomes->load('recurrentIncome'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIncomeRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($request->safe()->has('recurrent_income_id') && $validated['recurrent_income_id']) {
            $recurrentIncome = RecurrentIncome::where('id', $validated['recurrent_income_id'])->first();

            $validated['description'] = $recurrentIncome->description;
            $validated['value'] = $recurrentIncome->default_value;
        }

        $incomes = Income::create($validated);

        return response()->json($incomes, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income): JsonResource
    {
        $this->authorize('view', $income);

        return new IncomeResource($income->load('recurrentIncome'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIncomeRequest $request, Income $income): JsonResponse
    {
        $this->authorize('update', $income);

        // Assuring the recurrent income won`t be altered
        $validated = $request->safe()->except(['recurrent_income_id']);

        $income->update($validated);

        return response()->json($income);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income): JsonResponse
    {
        $this->authorize('delete', $income);

        $income->delete();

        return response()->json(['message' => 'Record deleted.']);
    }
}
