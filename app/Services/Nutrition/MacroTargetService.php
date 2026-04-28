<?php

namespace App\Services\Nutrition;

use App\Enums\GoalType;
use App\Models\GoalProfile;
use App\Models\Profile;

class MacroTargetService
{
    public function estimate(int $calorieTarget, Profile $profile, ?GoalProfile $goalProfile = null): array
    {
        $weight = (float) ($profile->current_weight_kg ?? 0);
        $goalType = $goalProfile?->goal_type ?? GoalType::FatLoss;

        $proteinPerKg = match ($goalType) {
            GoalType::MuscleRetention, GoalType::Recomposition => 2.0,
            GoalType::Maintenance => 1.7,
            GoalType::FatLoss => 1.9,
        };

        $protein = (int) round($weight * $proteinPerKg);
        $fat = max(45, (int) round(($calorieTarget * 0.28) / 9));
        $carbs = max(80, (int) round(($calorieTarget - ($protein * 4) - ($fat * 9)) / 4));

        return [
            'protein_g' => $goalProfile?->protein_target_g ?: $protein,
            'carb_g' => $goalProfile?->carb_target_g ?: $carbs,
            'fat_g' => $goalProfile?->fat_target_g ?: $fat,
        ];
    }
}
