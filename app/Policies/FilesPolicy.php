<?php

namespace App\Policies;

use App\Models\Files;
use App\Models\Reports;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FilesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Files $files): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        
    }

    /**
     * Determine whether the user can update the model.
     * hanya dapat mengupdate status dari file
     * yang dapat mengupdate status adalah target_id (penerima)
     */
    public function update(User $user, Files $file): bool
    {
        return $user->id===$file->report->target_id
        && !$file->status;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Files $files): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Files $files): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Files $files): bool
    {
        //
    }
}
