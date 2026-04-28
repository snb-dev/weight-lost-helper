<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'logged_on',
    'waist_cm',
    'chest_cm',
    'hips_cm',
    'thigh_cm',
    'arm_cm',
    'notes',
])]
class MeasurementLog extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'logged_on' => 'date',
            'waist_cm' => 'decimal:2',
            'chest_cm' => 'decimal:2',
            'hips_cm' => 'decimal:2',
            'thigh_cm' => 'decimal:2',
            'arm_cm' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
