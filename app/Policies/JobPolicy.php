<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;

class JobPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Anyone can view job listings
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Job $job): bool
    {
        return true; // Anyone can view individual jobs
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        return $user && $user->isClient();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Job $job): bool
    {
        return $user && $user->id === $job->client_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Job $job): bool
    {
        return $user && $user->id === $job->client_id && $job->isOpen();
    }

    /**
     * Determine whether the user can submit a proposal for the job.
     */
    public function submitProposal(?User $user, Job $job): bool
    {
        return $user && 
               $user->isOperator() && 
               $job->canReceiveProposals() &&
               $user->id !== $job->client_id;
    }

    /**
     * Determine whether the user can accept a proposal for the job.
     */
    public function acceptProposal(?User $user, Job $job): bool
    {
        return $user && $user->id === $job->client_id && $job->isOpen();
    }

    /**
     * Determine whether the user can reject a proposal for the job.
     */
    public function rejectProposal(?User $user, Job $job): bool
    {
        return $user && $user->id === $job->client_id && $job->isOpen();
    }

    /**
     * Determine whether the user can mark the job as completed.
     */
    public function markCompleted(?User $user, Job $job): bool
    {
        return $user && 
               $user->id === $job->client_id && 
               $job->isInProgress();
    }
}