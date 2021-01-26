<?php

namespace App\Policies;

use App\Models\Coordinator;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoordinatorPolicy{

    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user){
        return $user->isAdmin;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Coordinator  $coordinator
     * @return mixed
     */
    public function view(User $user, Coordinator $coordinator){
		return $user->isAdmin;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user){
		return $user->isAdmin;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Coordinator  $coordinator
     * @return mixed
     */
    public function update(User $user, Coordinator $coordinator){
		return $user->isAdmin;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Coordinator  $coordinator
     * @return mixed
     */
    public function delete(User $user, Coordinator $coordinator){
		return $user->isAdmin;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Coordinator  $coordinator
     * @return mixed
     */
    public function restore(User $user, Coordinator $coordinator)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Coordinator  $coordinator
     * @return mixed
     */
    public function forceDelete(User $user, Coordinator $coordinator)
    {
        //
    }

	/**
	 * Determine whether the user can reset password.
	 *
	 * @param \App\Models\User $user
	 * @param \App\Models\Coordinator $coordinator
	 * @return mixed
	 */
	public function resetPassword(User $user, Coordinator $coordinator){
		return $user->isAdmin;
	}
}
