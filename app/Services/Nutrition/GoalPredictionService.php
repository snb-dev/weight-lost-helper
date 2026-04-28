<?php

namespace App\Services\Nutrition;

use App\Models\Profile;
use Carbon\CarbonImmutable;

class GoalPredictionService
{
    public function estimate(Profile $profile, int $dailyCalorieTarget, int $maintenanceCalories): ?array
    {
        if (! $profile->current_weight_kg || ! $profile->goal_weight_kg || $dailyCalorieTarget >= $maintenanceCalories) {
            return null;
        }

        $weightToLose = max(0, $profile->current_weight_kg - $profile->goal_weight_kg);

        if ($weightToLose <= 0) {
            return null;
        }

        $dailyDeficit = $maintenanceCalories - $dailyCalorieTarget;
        $weeklyLossKg = ($dailyDeficit * 7) / 7700;

        if ($weeklyLossKg <= 0) {
            return null;
        }

        $weeks = (int) ceil($weightToLose / $weeklyLossKg);

        return [
            'weekly_loss_kg' => round($weeklyLossKg, 2),
            'estimated_goal_date' => CarbonImmutable::today()->addWeeks($weeks),
            'weeks_remaining' => $weeks,
        ];
    }
}
