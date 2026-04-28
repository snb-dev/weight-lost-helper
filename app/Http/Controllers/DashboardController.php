<?php

namespace App\Http\Controllers;

use App\Services\Nutrition\CalorieTargetService;
use App\Services\Nutrition\GoalPredictionService;
use App\Services\Nutrition\MacroTargetService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(
        Request $request,
        CalorieTargetService $calorieTargetService,
        MacroTargetService $macroTargetService,
        GoalPredictionService $goalPredictionService,
    ): View {
        $user = $request->user()->loadMissing(['profile', 'goalProfile', 'healthProfile']);
        $calories = $user->profile ? $calorieTargetService->estimate($user->profile, $user->goalProfile) : null;
        $macros = $user->profile && $calories['target']
            ? $macroTargetService->estimate($calories['target'], $user->profile, $user->goalProfile)
            : null;
        $prediction = $user->profile && $calories['target'] && $calories['maintenance']
            ? $goalPredictionService->estimate($user->profile, $calories['target'], $calories['maintenance'])
            : null;

        return view('dashboard', [
            'user' => $user,
            'calories' => $calories,
            'macros' => $macros,
            'prediction' => $prediction,
        ]);
    }
}
