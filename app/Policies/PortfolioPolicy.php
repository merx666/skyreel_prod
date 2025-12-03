<?php

namespace App\Policies;

use App\Models\Portfolio;
use App\Models\User;

class PortfolioPolicy
{
    public function view(?User $user, Portfolio $portfolio)
    {
        return true; // Portfolio są publiczne
    }

    public function create(User $user)
    {
        return $user->isOperator();
    }

    public function update(User $user, Portfolio $portfolio)
    {
        return $user->id === $portfolio->user_id;
    }

    public function delete(User $user, Portfolio $portfolio)
    {
        return $user->id === $portfolio->user_id;
    }
}