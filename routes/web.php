<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\RecipeStudioController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('onboarding', OnboardingController::class)
    ->middleware(['auth', 'verified'])
    ->name('onboarding');

Route::view('tracking', 'tracking.index')
    ->middleware(['auth', 'verified'])
    ->name('tracking.index');

Route::view('plans', 'plans.index')
    ->middleware(['auth', 'verified'])
    ->name('plans.index');

Route::get('recipes/studio', RecipeStudioController::class)
    ->middleware(['auth', 'verified'])
    ->name('recipes.studio');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
