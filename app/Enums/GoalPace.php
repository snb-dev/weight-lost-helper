<?php

namespace App\Enums;

enum GoalPace: string
{
    case Conservative = 'conservative';
    case Sustainable = 'sustainable';
    case Aggressive = 'aggressive';

    public function calorieAdjustment(): int
    {
        return match ($this) {
            self::Conservative => -250,
            self::Sustainable => -450,
            self::Aggressive => -700,
        };
    }
}
