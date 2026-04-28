<?php

namespace App\Models;

use App\Enums\GoalPace;
use App\Enums\GoalType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'goal_type',
    'goal_pace',
    'weekly_loss_target_kg',
    'daily_calorie_target',
    'protein_target_g',
    'carb_target_g',
    'fat_target_g',
    'meal_frequency',
    'motivation_style',
    'check_in_weekday',
])]
class GoalProfile extends Model
{
    protected function casts(): array
    {
        return [
            'goal_type' => GoalType::class,
            'goal_pace' => GoalPace::class,
            'weekly_loss_target_kg' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
