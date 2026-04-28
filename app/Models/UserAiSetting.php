<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'provider',
    'openrouter_api_key',
    'preferred_model',
    'allow_free_models',
])]
class UserAiSetting extends Model
{
    protected function casts(): array
    {
        return [
            'allow_free_models' => 'boolean',
            'openrouter_api_key' => 'encrypted',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
