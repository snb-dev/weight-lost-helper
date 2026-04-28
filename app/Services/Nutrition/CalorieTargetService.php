<?php

namespace App\Services\Nutrition;

use App\Enums\Gender;
use App\Enums\GoalPace;
use App\Models\GoalProfile;
use App\Models\Profile;

class CalorieTargetService
{
    public function estimate(Profile $profile, ?GoalProfile $goalProfile = null): array
    {
        if (! $profile->age || ! $profile->height_cm || ! $profile->current_weight_kg || ! $profile->gender || ! $profile->activity_level) {
            return [
                'bmr' => null,
                'maintenance' => null,
                'target' => null,
            ];
        }

        $bmr = match ($profile->gender) {
            Gender::Female => (10 * $profile->current_weight_kg) + (6.25 * $profile->height_cm) - (5 * $profile->age) - 161,
            default => (10 * $profile->current_weight_kg) + (6.25 * $profile->height_cm) - (5 * $profile->age) + 5,
        };

        $maintenance = (int) round($bmr * $profile->activity_level->multiplier());
        $pace = $goalProfile?->goal_pace ?? GoalPace::Sustainable;
        $target = max(config('weightloss.calories.minimum_safe_target'), $maintenance + $pace->calorieAdjustment());

        return [
            'bmr' => (int) round($bmr),
            'maintenance' => $maintenance,
            'target' => $goalProfile?->daily_calorie_target ?: $target,
        ];
    }
}
