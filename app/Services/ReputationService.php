<?php

namespace App\Services;

use App\Models\User;

class ReputationService
{
    public function awardPoints(User $user, int $points): void
    {
        $user->increment('reputation_score', $points);
    }
}