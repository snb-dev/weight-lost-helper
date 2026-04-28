<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id',
    'title',
    'summary',
    'meal_type',
    'cuisine',
    'servings',
    'prep_minutes',
    'cook_minutes',
    'total_calories',
    'protein_g',
    'carb_g',
    'fat_g',
    'ingredients',
    'steps',
    'nutrition_payload',
    'substitutions',
    'tags',
    'source',
])]
class Recipe extends Model
{
    protected function casts(): array
    {
        return [
            'ingredients' => 'array',
            'steps' => 'array',
            'nutrition_payload' => 'array',
            'substitutions' => 'array',
            'tags' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function generations(): HasMany
    {
        return $this->hasMany(RecipeGeneration::class);
    }
}
