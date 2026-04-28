<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('gender')->nullable();
            $table->unsignedSmallInteger('height_cm')->nullable();
            $table->decimal('current_weight_kg', 5, 2)->nullable();
            $table->decimal('goal_weight_kg', 5, 2)->nullable();
            $table->date('target_date')->nullable();
            $table->string('activity_level')->nullable();
            $table->string('country_region')->nullable();
            $table->string('daily_schedule')->nullable();
            $table->string('cooking_skill_level')->nullable();
            $table->string('food_budget_level')->nullable();
            $table->text('workout_habits')->nullable();
            $table->decimal('water_intake_liters', 4, 2)->nullable();
            $table->decimal('sleep_hours', 3, 1)->nullable();
            $table->unsignedTinyInteger('stress_level')->nullable();
            $table->string('preferred_units')->default('metric');
            $table->timestamp('onboarding_completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('health_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->decimal('body_fat_percentage', 5, 2)->nullable();
            $table->string('dietary_preference')->nullable();
            $table->json('allergies')->nullable();
            $table->json('foods_to_avoid')->nullable();
            $table->json('medical_conditions')->nullable();
            $table->json('religious_restrictions')->nullable();
            $table->json('injuries_limitations')->nullable();
            $table->json('medications')->nullable();
            $table->json('cuisine_preferences')->nullable();
            $table->timestamps();
        });

        Schema::create('goal_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('goal_type')->default('fat_loss');
            $table->string('goal_pace')->default('sustainable');
            $table->decimal('weekly_loss_target_kg', 4, 2)->nullable();
            $table->unsignedSmallInteger('daily_calorie_target')->nullable();
            $table->unsignedSmallInteger('protein_target_g')->nullable();
            $table->unsignedSmallInteger('carb_target_g')->nullable();
            $table->unsignedSmallInteger('fat_target_g')->nullable();
            $table->unsignedTinyInteger('meal_frequency')->default(3);
            $table->string('motivation_style')->nullable();
            $table->unsignedTinyInteger('check_in_weekday')->default(1);
            $table->timestamps();
        });

        Schema::create('user_pantry_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('ingredient');
            $table->decimal('quantity', 8, 2)->nullable();
            $table->string('unit')->nullable();
            $table->date('expires_on')->nullable();
            $table->timestamps();
        });

        Schema::create('weight_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('logged_on');
            $table->decimal('weight_kg', 5, 2);
            $table->decimal('bmi', 5, 2)->nullable();
            $table->text('notes')->nullable();
            $table->unique(['user_id', 'logged_on']);
        });

        Schema::create('measurement_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('logged_on');
            $table->decimal('waist_cm', 5, 2)->nullable();
            $table->decimal('chest_cm', 5, 2)->nullable();
            $table->decimal('hips_cm', 5, 2)->nullable();
            $table->decimal('thigh_cm', 5, 2)->nullable();
            $table->decimal('arm_cm', 5, 2)->nullable();
            $table->text('notes')->nullable();
            $table->unique(['user_id', 'logged_on']);
        });

        Schema::create('calorie_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('logged_on');
            $table->unsignedSmallInteger('consumed_calories');
            $table->unsignedSmallInteger('protein_g')->nullable();
            $table->unsignedSmallInteger('carb_g')->nullable();
            $table->unsignedSmallInteger('fat_g')->nullable();
            $table->json('meal_breakdown')->nullable();
            $table->timestamps();
        });

        Schema::create('water_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('logged_on');
            $table->decimal('liters', 4, 2);
            $table->timestamps();
        });

        Schema::create('habit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('logged_on');
            $table->string('habit');
            $table->boolean('completed')->default(false);
            $table->unsignedTinyInteger('score')->nullable();
            $table->timestamps();
        });

        Schema::create('progress_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->date('logged_on');
            $table->string('visibility')->default('private');
            $table->timestamps();
        });

        Schema::create('milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('unlocked_on')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('diet_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('status')->default('draft');
            $table->date('starts_on')->nullable();
            $table->date('ends_on')->nullable();
            $table->unsignedSmallInteger('daily_calorie_target')->nullable();
            $table->unsignedSmallInteger('protein_target_g')->nullable();
            $table->unsignedSmallInteger('carb_target_g')->nullable();
            $table->unsignedSmallInteger('fat_target_g')->nullable();
            $table->json('grocery_payload')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('diet_plan_meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diet_plan_id')->constrained()->cascadeOnDelete();
            $table->date('planned_for');
            $table->string('meal_type');
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('target_calories')->nullable();
            $table->unsignedSmallInteger('protein_g')->nullable();
            $table->unsignedSmallInteger('carb_g')->nullable();
            $table->unsignedSmallInteger('fat_g')->nullable();
            $table->timestamps();
        });

        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('summary')->nullable();
            $table->string('meal_type')->nullable();
            $table->string('cuisine')->nullable();
            $table->unsignedTinyInteger('servings')->default(1);
            $table->unsignedSmallInteger('prep_minutes')->nullable();
            $table->unsignedSmallInteger('cook_minutes')->nullable();
            $table->unsignedSmallInteger('total_calories')->nullable();
            $table->unsignedSmallInteger('protein_g')->nullable();
            $table->unsignedSmallInteger('carb_g')->nullable();
            $table->unsignedSmallInteger('fat_g')->nullable();
            $table->json('ingredients');
            $table->json('steps');
            $table->json('nutrition_payload')->nullable();
            $table->json('substitutions')->nullable();
            $table->json('tags')->nullable();
            $table->string('source')->default('ai');
            $table->timestamps();
        });

        Schema::create('recipe_generations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recipe_id')->nullable()->constrained()->nullOnDelete();
            $table->json('request_payload');
            $table->json('response_payload')->nullable();
            $table->string('model');
            $table->string('status')->default('queued');
            $table->timestamp('generated_at')->nullable();
        });

        Schema::create('recipe_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'recipe_id']);
        });

        Schema::create('user_ai_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('provider')->default('openrouter');
            $table->text('openrouter_api_key')->nullable();
            $table->string('preferred_model')->nullable();
            $table->boolean('allow_free_models')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_ai_settings');
        Schema::dropIfExists('recipe_bookmarks');
        Schema::dropIfExists('recipe_generations');
        Schema::dropIfExists('recipes');
        Schema::dropIfExists('diet_plan_meals');
        Schema::dropIfExists('diet_plans');
        Schema::dropIfExists('milestones');
        Schema::dropIfExists('progress_photos');
        Schema::dropIfExists('habit_logs');
        Schema::dropIfExists('water_logs');
        Schema::dropIfExists('calorie_logs');
        Schema::dropIfExists('measurement_logs');
        Schema::dropIfExists('weight_logs');
        Schema::dropIfExists('user_pantry_items');
        Schema::dropIfExists('goal_profiles');
        Schema::dropIfExists('health_profiles');
        Schema::dropIfExists('profiles');
    }
};
