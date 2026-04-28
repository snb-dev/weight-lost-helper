<?php

namespace App\Services\OpenRouter;

use App\Models\User;

class OpenRouterRecipeService
{
    public function buildPayload(User $user, array $constraints): array
    {
        return [
            'provider' => 'openrouter',
            'model' => $user->aiSetting?->preferred_model ?: config('openrouter.default_model'),
            'allow_free_models' => $user->aiSetting?->allow_free_models ?? true,
            'system_prompt' => 'You are a nutrition-aware recipe assistant. Return structured healthy recipes tailored to the user profile.',
            'user_context' => [
                'profile' => $user->profile?->toArray(),
                'health' => $user->healthProfile?->toArray(),
                'goals' => $user->goalProfile?->toArray(),
            ],
            'constraints' => $constraints,
            'output_schema' => [
                'title',
                'summary',
                'ingredients',
                'steps',
                'nutrition',
                'substitutions',
                'tags',
            ],
        ];
    }
}
