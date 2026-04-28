<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'logged_on', 'weight_kg', 'bmi', 'notes'])]
class WeightLog extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'logged_on' => 'date',
            'weight_kg' => 'decimal:2',
            'bmi' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
