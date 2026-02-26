<?php

namespace App\Providers;

use App\Models\JobResult;
use App\Models\User;
use App\Policies\JobResultPolicy;
use App\Policies\NavigationPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Model::automaticallyEagerLoadRelationships();

        Gate::policy(User::class, NavigationPolicy::class);
        Gate::policy(JobResult::class, JobResultPolicy::class);

        Blade::if('systemAdministrationView', fn () => Gate::check('systemAdministrationView', Auth::user()));
        Blade::if('companyAdministrationView', fn () => Gate::check('companyAdministrationView', Auth::user()));
        Blade::if('operationsManagerView', fn () => Gate::check('operationsManagerView', Auth::user()));
        Blade::if('projectsManagerView', fn () => Gate::check('projectsManagerView', Auth::user()));
        Blade::if('siteAdministrationView', fn () => Gate::check('siteAdministrationView', Auth::user()));
        Blade::if('siteManagementView', fn () => Gate::check('siteManagementView', Auth::user()));
        Blade::if('financeManagerView', fn () => Gate::check('financeManagerView', Auth::user()));
        Blade::if('hrManagerView', fn () => Gate::check('hrManagerView', Auth::user()));
        Blade::if('hrOfficerView', fn () => Gate::check('hrOfficerView', Auth::user()));
        Blade::if('payrollOfficerView', fn () => Gate::check('payrollOfficerView', Auth::user()));
    }
}
