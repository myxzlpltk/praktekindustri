<?php

namespace App\Policies;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProposalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user){
		return $user->isAdmin || $user->isCoordinator;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposal  $proposal
     * @return mixed
     */
    public function view(User $user, Proposal $proposal){
        return $user->isAdmin
			|| $user->isCoordinator
			|| ($user->isStudent && $user->student->id == $proposal->student_id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user){
		return $user->isStudent && $user->student->proposals()->count() == 0;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposal  $proposal
     * @return mixed
     */
    public function update(User $user, Proposal $proposal){
		return $user->isAdmin || $user->isCoordinator;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposal  $proposal
     * @return mixed
     */
    public function delete(User $user, Proposal $proposal)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposal  $proposal
     * @return mixed
     */
    public function restore(User $user, Proposal $proposal)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proposal  $proposal
     * @return mixed
     */
    public function forceDelete(User $user, Proposal $proposal)
    {
        //
    }
}
