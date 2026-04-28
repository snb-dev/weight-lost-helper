<?php

return [
    'calories' => [
        'minimum_safe_target' => (int) env('WEIGHTLOSS_MINIMUM_SAFE_TARGET', 1200),
        'water_goal_liters' => (float) env('WEIGHTLOSS_DEFAULT_WATER_GOAL', 2.5),
    ],
    'milestones' => [
        'first_log_days' => 7,
        'streak_days' => 14,
        'weight_drop_percent' => 5,
    ],
];
