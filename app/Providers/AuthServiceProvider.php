<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Expense;
use App\Models\ExpensesCategory;
use App\Models\Income;
use App\Models\Notification;
use App\Models\RecurrentExpense;
use App\Models\RecurrentIncome;
use App\Models\User;
use App\Policies\ExpensePolicy;
use App\Policies\ExpensesCategoryPolicy;
use App\Policies\IncomePolicy;
use App\Policies\NotificationPolicy;
use App\Policies\RecurrentExpensePolicy;
use App\Policies\RecurrentIncomePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Expense::class, ExpensePolicy::class,
        ExpensesCategory::class, ExpensesCategoryPolicy::class,
        Income::class, IncomePolicy::class,
        Notification::class, NotificationPolicy::class,
        RecurrentExpense::class, RecurrentExpensePolicy::class,
        RecurrentIncome::class, RecurrentIncomePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

//        Gate::define('show-expense', function (User $user, Expense $expense) {
//            return $user->id === $expense->user_id;
//        });
//        Gate::define('update-expense', function (User $user, Expense $expense) {
//            return $user->id === $expense->user_id;
//        });
//        Gate::define('delete-expense', function (User $user, Expense $expense) {
//            return $user->id === $expense->user_id;
//        });
    }
}
