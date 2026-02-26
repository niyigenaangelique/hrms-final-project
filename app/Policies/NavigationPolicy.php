<?php

namespace App\Policies;

use App\Enum\UserRole;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NavigationPolicy
{
    use HandlesAuthorization;

    public function systemAdministrationView(User $user): bool
    {
        return in_array($user->role, [
            UserRole::SuperAdmin,
            UserRole::DataMaster
        ]);
    }

    public function companyAdministrationView(User $user): bool
    {
        return in_array($user->role, [
            UserRole::SuperAdmin,
            UserRole::CompanyAdmin,
            UserRole::DataMaster,
            UserRole::CompanyDataMaster,
            UserRole::LeadershipTeamMember
        ]);
    }

    public function operationsManagerView(User $user): bool
    {
        return in_array($user->role, [
            UserRole::SuperAdmin,
            UserRole::CompanyAdmin,
            UserRole::OperationsManager,
            UserRole::DataMaster,
            UserRole::CompanyDataMaster,
            UserRole::LeadershipTeamMember
        ]);
    }

    public function projectsManagerView(User $user): bool
    {
        return in_array($user->role, [
            UserRole::SuperAdmin,
            UserRole::CompanyAdmin,
            UserRole::OperationsManager,
            UserRole::ProjectManager,
            UserRole::DataMaster,
            UserRole::CompanyDataMaster,
            UserRole::LeadershipTeamMember
        ]);
    }

    public function siteAdministrationView(User $user): bool
    {
        return in_array($user->role, [
            UserRole::SuperAdmin,
            UserRole::CompanyAdmin,
            UserRole::SiteAdmin,
            UserRole::SiteManager,
            UserRole::DataMaster,
            UserRole::CompanyDataMaster
        ]);
    }

    public function siteManagementView(User $user): bool
    {
        return in_array($user->role, [
            UserRole::SuperAdmin,
            UserRole::CompanyAdmin,
            UserRole::OperationsManager,
            UserRole::ProjectManager,
            UserRole::SiteAdmin,
            UserRole::SiteManager,
            UserRole::SiteSupervisor,
            UserRole::DataMaster,
            UserRole::CompanyDataMaster,
            UserRole::LeadershipTeamMember
        ]);
    }

    public function financeManagerView(User $user): bool
    {
        return in_array($user->role, [
            UserRole::SuperAdmin,
            UserRole::CompanyAdmin,
            UserRole::FinanceManager,
            UserRole::FinanceAdmin,
            UserRole::FinanceOfficer,
            UserRole::DataMaster,
            UserRole::CompanyDataMaster,
            UserRole::LeadershipTeamMember
        ]);
    }

    public function hrManagerView(User $user): bool
    {
        return in_array($user->role, [
            UserRole::SuperAdmin,
            UserRole::CompanyAdmin,
            UserRole::HRManager,
            UserRole::HRAdmin,
            UserRole::DataMaster,
            UserRole::CompanyDataMaster,
            UserRole::LeadershipTeamMember
        ]);
    }

    public function hrOfficerView(User $user): bool
    {
        return in_array($user->role, [
            UserRole::SuperAdmin,
            UserRole::CompanyAdmin,
            UserRole::HROfficer,
            UserRole::HRManager,
            UserRole::HRAdmin,
            UserRole::DataMaster,
            UserRole::CompanyDataMaster
        ]);
    }

    public function payrollOfficerView(User $user): bool
    {
        return in_array($user->role, [
            UserRole::SuperAdmin,
            UserRole::CompanyAdmin,
            UserRole::PayrollOfficer,
            UserRole::HRManager,
            UserRole::HRAdmin,
            UserRole::FinanceManager,
            UserRole::FinanceAdmin,
            UserRole::DataMaster,
            UserRole::CompanyDataMaster
        ]);
    }

    public function hrClarkView(User $user): bool
    {
        return in_array($user->role, [
            UserRole::SuperAdmin,
            UserRole::CompanyAdmin,
            UserRole::HRClark,
            UserRole::HRManager,
            UserRole::HRAdmin,
            UserRole::FinanceManager,
            UserRole::FinanceAdmin,
            UserRole::DataMaster,
            UserRole::CompanyDataMaster
        ]);
    }
    public function dataMasterView(User $user): bool
    {
        return in_array($user->role, [
            UserRole::SuperAdmin,
            UserRole::CompanyAdmin,
            UserRole::DataMaster,
            UserRole::CompanyDataMaster
        ]);
    }
}
