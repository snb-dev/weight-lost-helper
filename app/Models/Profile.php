<?php

namespace App\Models;

use App\Enums\ActivityLevel;
use App\Enums\Gender;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'age',
    'gender',
    'height_cm',
    'current_weight_kg',
    'goal_weight_kg',
    'target_date',
    'activity_level',
    'country_region',
    'daily_schedule',
    'cooking_skill_level',
    'food_budget_level',
    'workout_habits',
    'water_intake_liters',
    'sleep_hours',
    'stress_level',
    'preferred_units',
    'onboarding_completed_at',
])]
class Profile extends Model
{
    protected function casts(): array
    {
        return [
            'gender' => Gender::class,
            'activity_level' => ActivityLevel::class,
            'target_date' => 'date',
            'water_intake_liters' => 'decimal:2',
            'sleep_hours' => 'decimal:1',
            'onboarding_completed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
