<?php

namespace App\Policies;

use App\Enums\UserType;
use App\Models\Learner;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LearnerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->type === UserType::ADMINISTRATOR;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Learner $learner): bool
    {
        return $learner->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Learner $learner): bool
    {
        return $learner->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Learner $learner): bool
    {
        return $learner->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Learner $learner): bool
    {
        return $learner->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Learner $learner): bool
    {
        return $learner->user_id === $user->id;
    }
}
