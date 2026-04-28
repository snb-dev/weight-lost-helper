<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'diet_plan_id',
    'planned_for',
    'meal_type',
    'title',
    'description',
    'target_calories',
    'protein_g',
    'carb_g',
    'fat_g',
])]
class DietPlanMeal extends Model
{
    protected function casts(): array
    {
        return [
            'planned_for' => 'date',
        ];
    }

    public function dietPlan(): BelongsTo
    {
        return $this->belongsTo(DietPlan::class);
    }
}
