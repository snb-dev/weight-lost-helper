<?php

namespace Tests\Unit;

use App\Models\GoalProfile;
use App\Models\Profile;
use App\Services\Nutrition\CalorieTargetService;
use App\Services\Nutrition\GoalPredictionService;
use App\Services\Nutrition\MacroTargetService;
use Tests\TestCase;

class NutritionServicesTest extends TestCase
{
    public function test_calorie_and_macro_targets_are_estimated(): void
    {
        $profile = new Profile([
            'age' => 30,
            'gender' => 'male',
            'height_cm' => 180,
            'current_weight_kg' => 95,
            'goal_weight_kg' => 82,
            'activity_level' => 'moderate',
        ]);

        $goals = new GoalProfile([
            'goal_type' => 'fat_loss',
            'goal_pace' => 'sustainable',
        ]);

        $calories = (new CalorieTargetService())->estimate($profile, $goals);
        $macros = (new MacroTargetService())->estimate($calories['target'], $profile, $goals);
        $prediction = (new GoalPredictionService())->estimate($profile, $calories['target'], $calories['maintenance']);

        $this->assertNotNull($calories['maintenance']);
        $this->assertNotNull($calories['target']);
        $this->assertGreaterThan(0, $macros['protein_g']);
        $this->assertNotNull($prediction);
    }
}
