<?php

namespace App\Policies;

use App\Enum\UserRole;
use App\Models\JobResult;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobResultPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {

        return in_array($user->role, [
            UserRole::SuperAdmin,
            UserRole::CompanyAdmin,
            UserRole::DataMaster,
        ]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, JobResult $jobResult): bool
    {
        // SuperAdmin and CompanyAdmin can view all job results
        if (in_array($user->role, [UserRole::SuperAdmin, UserRole::CompanyAdmin])) {
            return true;
        }

        // DataMaster can view their own job results
        if ($user->role === UserRole::DataMaster && $jobResult->user_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, JobResult $jobResult): bool
    {
        // Only SuperAdmin can delete job results
        return $user->role === UserRole::SuperAdmin;

    }

    public function forceDelete(User $user, JobResult $jobResult): bool
    {
        // Only SuperAdmin can delete job results
        return $user->role === UserRole::SuperAdmin;

    }
}
