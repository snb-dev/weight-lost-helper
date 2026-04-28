<?php

namespace Tests\Feature;

use App\Models\GoalProfile;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppShellTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_landing_page_renders_weight_loss_helper_content(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Weight Loss Helper');
        $response->assertSee('A modern weight loss platform');
    }

    public function test_authenticated_user_can_view_dashboard_with_estimates(): void
    {
        $user = User::factory()->create();

        Profile::create([
            'user_id' => $user->id,
            'age' => 32,
            'gender' => 'female',
            'height_cm' => 165,
            'current_weight_kg' => 78,
            'goal_weight_kg' => 65,
            'activity_level' => 'moderate',
        ]);

        GoalProfile::create([
            'user_id' => $user->id,
            'goal_type' => 'fat_loss',
            'goal_pace' => 'sustainable',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Fat-loss target');
        $response->assertSee('Macro guidance');
    }
}
