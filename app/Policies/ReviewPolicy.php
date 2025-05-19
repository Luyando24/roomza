<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Review $review): bool
    {
        return true; // Anyone can view approved reviews
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Any authenticated user can create reviews
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Review $review): bool
    {
        return $user->id === $review->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Review $review): bool
    {
        return $user->id === $review->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can respond to the review.
     */
    public function respond(User $user, Review $review): bool
    {
        return $user->id === $review->property->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can approve the review.
     */
    public function approve(User $user, Review $review): bool
    {
        return $user->hasRole('admin');
    }
}