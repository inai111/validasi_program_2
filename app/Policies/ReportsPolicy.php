<?php

namespace App\Policies;

use App\Models\Reports;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReportsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return !$user->roles->contains('name_code','admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reports $reports): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return !$user->roles->contains('admin')
        ||$user->roles->contains(function($value){
            return in_array($value['name_code'],['kabag','direct']);
        });
    }

    /**
     * Determine whether the user can update the model.
     * hanya dapat mengupdate status selama status report
     * masih progress
     * yaitu si pembuat report dan penerima report
     */
    public function update(User $user, Reports $report): bool
    {
        // return in_array($user->id,[$report->user_id,$report->target_id])
        // hanya pembuat, karena ada button cancel
        return $user->id==$report->user_id
        && $report->status==='progress';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reports $report): bool
    {
        return in_array($report->status,['canceled','rejected'])
        && $user->id===$report->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Reports $reports): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Reports $reports): bool
    {
        //
    }

    public function uploadFile(User $user,Reports $report): bool
    {
        return in_array($user->id,[$report->user_id,$report->target_id])
        && $report->status==='progress';
    }

    public function uploadRevision(User $user,Reports $report): bool
    {
        $report->files()->get()->last();
        return in_array($user->id,[$report->user_id,$report->target_id])
        && $report->status==='progress';
    }
}
