<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'body_fat_percentage',
    'dietary_preference',
    'allergies',
    'foods_to_avoid',
    'medical_conditions',
    'religious_restrictions',
    'injuries_limitations',
    'medications',
    'cuisine_preferences',
])]
class HealthProfile extends Model
{
    protected function casts(): array
    {
        return [
            'body_fat_percentage' => 'decimal:2',
            'allergies' => 'array',
            'foods_to_avoid' => 'array',
            'medical_conditions' => 'array',
            'religious_restrictions' => 'array',
            'injuries_limitations' => 'array',
            'medications' => 'array',
            'cuisine_preferences' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
