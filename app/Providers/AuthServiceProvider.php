<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Classroom' => 'App\Policies\ClassroomPolicy',
        'App\Models\ParentIncome' => 'App\Policies\ParentIncomePolicy',
        'App\Models\ParentCompletness' => 'App\Policies\ParentCompletnessPolicy',
        'App\Models\OtherCriteria' => 'App\Policies\OtherCriteriaPolicy',
        'App\Models\Profit' => 'App\Policies\ProfitPolicy',
        'App\Models\Student' => 'App\Policies\StudentPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
