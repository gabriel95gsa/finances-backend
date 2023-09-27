<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Http\Resources\IncomeResource;
use App\Models\Income;
use App\Models\RecurrentIncome;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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
            $validated['value'] = $validated['value'] ?? $recurrentIncome->default_value;
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

    /**
     * List all incomes (joining incomes and recurrent_incomes) by period (ex.: 2023-05)
     *
     * @param string|null $period
     * @return JsonResponse
     */
    public function listAllIncomesByPeriod(?string $period = null): JsonResponse
    {
        $currentMonth = $period ?? Carbon::now()->format('Y-m');
        $userId = auth()->user()->id;

        /*
         * For this query, only rows from recurrent_incomes table
         * will have recurrent_income_id value and
         * only rows from incomes table will have income_id value
         */
        $incomesQuery = DB::table('incomes')
            ->select(
                DB::raw("id as income_id"),
                'description',
                'value',
                'period_date',
                DB::raw("NULL as recurrent_income_id"),
            )
            ->where('user_id', $userId)
            ->where('period_date', $currentMonth);

        $incomes = DB::table('recurrent_incomes')
            ->select(
                DB::raw("NULL as income_id"),
                'description',
                'default_value as value',
                DB::raw("'{$currentMonth}' as period_date"),
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
                $query
                    ->select('recurrent_income_id')
                    ->from('incomes')
                    ->where('incomes.user_id', $userId)
                    ->where('incomes.period_date', $currentMonth)
                    ->whereNotNull('recurrent_income_id');
            })
            ->union($incomesQuery)
            ->get();

        return response()->json($incomes);
    }
}
