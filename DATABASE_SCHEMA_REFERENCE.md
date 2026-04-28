# Database Schema Reference Guide

> Quick reference for all tables, relationships, and fields  
> Use this when building features to understand data structure

---

## TABLE RELATIONSHIPS MAP

```
users (base)
├─── 1:1 ──→ profiles (user info, goals, preferences)
├─── 1:1 ──→ health_profiles (medical, dietary data)
├─── 1:1 ──→ goal_profiles (weight loss targets)
├─── 1:N ──→ weight_logs (weight tracking)
├─── 1:N ──→ measurement_logs (body measurements)
├─── 1:N ──→ calorie_logs (nutrition tracking)
├─── 1:N ──→ water_logs (hydration tracking)
├─── 1:N ──→ habit_logs (daily habits)
├─── 1:N ──→ progress_photos (before/after photos)
├─── 1:N ──→ milestones (achievements)
├─── 1:N ──→ diet_plans (meal plans)
├─── 1:N ──→ recipes (bookmarks & saves)
├─── 1:N ──→ recipe_generations (AI request history)
├─── 1:N ──→ recipe_bookmarks (saved recipes)
├─── 1:N ──→ user_ai_settings (OpenRouter config)
└─── 1:N ──→ user_pantry_items (ingredient inventory)

diet_plans
└─── 1:N ──→ diet_plan_meals (meals within plans)

recipes
├─── 1:N ──→ recipe_bookmarks (users who saved)
└─── 1:N ──→ recipe_generations (AI generation history)
```

---

## DETAILED SCHEMA

### 🔐 USERS TABLE

```sql
Column              Type            Description
─────────────────────────────────────────────────────────
id                  BIGINT          Primary key
name                VARCHAR         User's full name
email               VARCHAR UNIQUE  Email address
password            VARCHAR         Hashed password
role                VARCHAR         Admin/User (from enum)
timezone            VARCHAR         User's timezone
country_region      VARCHAR         Location
created_at          TIMESTAMP       Registration date
updated_at          TIMESTAMP       Last update
email_verified_at   TIMESTAMP       Email verification status
```

**Eloquent Model**: `User`  
**Relationships**:

- `profile()` - OneToOne Profile
- `healthProfile()` - OneToOne HealthProfile
- `goalProfile()` - OneToOne GoalProfile
- `weightLogs()` - HasMany WeightLog
- `dietPlans()` - HasMany DietPlan
- `recipes()` - HasMany Recipe

---

### 👤 PROFILES TABLE

**Purpose**: User personalization data - heights, weights, goals, lifestyle

```sql
Column                      Type            Description
─────────────────────────────────────────────────────────────
id                          BIGINT          Primary key
user_id                     BIGINT FK       User reference (UNIQUE)
age                         TINYINT         Age in years
gender                      VARCHAR         Male/Female/Other
height_cm                   SMALLINT        Height in cm
current_weight_kg           DECIMAL(5,2)    Current weight kg
goal_weight_kg              DECIMAL(5,2)    Target weight kg
target_date                 DATE            Goal deadline
activity_level              VARCHAR         Sedentary/Light/Moderate/Very Active
country_region              VARCHAR         Region for localization
daily_schedule              VARCHAR         Work schedule type
cooking_skill_level         VARCHAR         Beginner/Intermediate/Advanced
food_budget_level           VARCHAR         Low/Medium/High
workout_habits              TEXT            Describes exercise routine
water_intake_liters         DECIMAL(4,2)    Daily target water (liters)
sleep_hours                 DECIMAL(3,1)    Average sleep hours/night
stress_level                TINYINT         1-10 scale
preferred_units             VARCHAR         metric/imperial
onboarding_completed_at     TIMESTAMP       When onboarding finished
created_at                  TIMESTAMP       Created
updated_at                  TIMESTAMP       Updated
```

**When to query**:

- Calculate BMI: `height_cm` + `current_weight_kg`
- Estimate calorie needs: Use age, gender, activity_level, height, weight
- Show goal timeline: `target_date` - today
- Personalize recommendations: Use all fields

**Example Query**:

```php
$profile = auth()->user()->profile;
$bmi = $profile->current_weight_kg / (($profile->height_cm / 100) ** 2);
$daysToGoal = now()->diffInDays($profile->target_date);
```

---

### ❤️ HEALTH_PROFILES TABLE

**Purpose**: Medical, dietary restrictions, and health conditions

```sql
Column                      Type            Description
─────────────────────────────────────────────────────────────
id                          BIGINT          Primary key
user_id                     BIGINT FK       User reference (UNIQUE)
body_fat_percentage         DECIMAL(5,2)    Optional body fat %
dietary_preference          VARCHAR         Vegan/Vegetarian/Keto/Low-Carb/etc
allergies                   JSON            Array of allergens
foods_to_avoid              JSON            Array of foods to skip
medical_conditions          JSON            Array of conditions
religious_restrictions      JSON            Array of restrictions
injuries_limitations        JSON            Array of injuries/limitations
medications                 JSON            Array of medications
cuisine_preferences         JSON            Array of preferred cuisines
created_at                  TIMESTAMP       Created
updated_at                  TIMESTAMP       Updated
```

**JSON Array Examples**:

```json
"allergies": ["nuts", "shellfish", "dairy"]
"dietary_preference": "vegetarian"
"medical_conditions": ["diabetes", "hypertension"]
"cuisine_preferences": ["Italian", "Asian", "Mediterranean"]
```

**When to use**:

- Filter recipes by dietary_preference
- Exclude allergenic ingredients from recipes
- Adapt meal plans to medical conditions
- Personalize cuisine recommendations

---

### 🎯 GOAL_PROFILES TABLE

**Purpose**: Weight loss targets and macro calculations

```sql
Column                      Type            Description
─────────────────────────────────────────────────────────────
id                          BIGINT          Primary key
user_id                     BIGINT FK       User reference (UNIQUE)
goal_type                   VARCHAR         fat_loss/muscle_gain/maintenance
goal_pace                   VARCHAR         fast/sustainable (kg/week)
weekly_loss_target_kg       DECIMAL(4,2)    Target weekly weight loss
daily_calorie_target        SMALLINT        Calorie goal (kcal/day)
protein_target_g            SMALLINT        Protein goal (g/day)
carb_target_g               SMALLINT        Carb goal (g/day)
fat_target_g                SMALLINT        Fat goal (g/day)
meal_frequency              TINYINT         Number of meals/day (3, 4, 5, 6)
motivation_style            VARCHAR         Email/Badge/Challenge/Other
check_in_weekday            TINYINT         Day for weekly check-in (1-7)
created_at                  TIMESTAMP       Created
updated_at                  TIMESTAMP       Updated
```

**Calculated Fields**:

- `daily_calorie_target` - from CalorieTargetService
- `protein_target_g`, `carb_target_g`, `fat_target_g` - from MacroTargetService

**Example Query**:

```php
$goal = auth()->user()->goalProfile;
$remaining_calories = $goal->daily_calorie_target - $today_consumed;
$macro_split = [
    'protein' => $goal->protein_target_g,
    'carbs' => $goal->carb_target_g,
    'fat' => $goal->fat_target_g,
];
```

---

### ⚖️ WEIGHT_LOGS TABLE

**Purpose**: Track historical weight entries - core tracking feature

```sql
Column              Type            Description
─────────────────────────────────────────────────────────
id                  BIGINT          Primary key
user_id             BIGINT FK       User reference
logged_on           DATE            Date of log entry
weight_kg           DECIMAL(5,2)    Weight recorded (kg)
bmi                 DECIMAL(5,2)    Calculated BMI
notes               TEXT            Optional notes (mood, comments)
created_at          TIMESTAMP       When logged
updated_at          TIMESTAMP       Last updated

UNIQUE(user_id, logged_on)  ← Only 1 entry per day per user
```

**Indexes**:

- `user_id` - for querying user's logs
- `logged_on` - for date range queries

**Example Queries**:

```php
// This week's weight entries
$weekLogs = WeightLog::whereBetween('logged_on', [
    now()->startOfWeek(),
    now()->endOfWeek()
])->get();

// Weight lost this month
$monthStart = now()->startOfMonth();
$firstLog = WeightLog::where('logged_on', '>=', $monthStart)->first();
$latestLog = WeightLog::latest('logged_on')->first();
$weightLost = $firstLog->weight_kg - $latestLog->weight_kg;
```

---

### 📏 MEASUREMENT_LOGS TABLE

**Purpose**: Track body measurements - optional but useful for body composition

```sql
Column              Type            Description
─────────────────────────────────────────────────────────
id                  BIGINT          Primary key
user_id             BIGINT FK       User reference
logged_on           DATE            Date of measurement
waist_cm            DECIMAL(5,2)    Waist measurement (cm)
chest_cm            DECIMAL(5,2)    Chest measurement (cm)
hips_cm             DECIMAL(5,2)    Hip measurement (cm)
thigh_cm            DECIMAL(5,2)    Thigh measurement (cm)
arm_cm              DECIMAL(5,2)    Arm measurement (cm)
notes               TEXT            Optional notes
created_at          TIMESTAMP       Created
updated_at          TIMESTAMP       Updated

UNIQUE(user_id, logged_on)  ← One entry per day
```

---

### 🍎 CALORIE_LOGS TABLE

**Purpose**: Track daily nutrition - calories, macros, meals

```sql
Column              Type            Description
─────────────────────────────────────────────────────────
id                  BIGINT          Primary key
user_id             BIGINT FK       User reference
logged_on           DATE            Date of entry
consumed_calories   SMALLINT        Total daily calories
protein_g           SMALLINT        Total protein (g)
carb_g              SMALLINT        Total carbs (g)
fat_g               SMALLINT        Total fat (g)
meal_breakdown      JSON            Per-meal details
created_at          TIMESTAMP       Created
updated_at          TIMESTAMP       Updated
```

**meal_breakdown JSON Example**:

```json
[
    {
        "meal_type": "breakfast",
        "foods": ["2 eggs", "1 toast"],
        "calories": 300,
        "protein": 15,
        "carbs": 30,
        "fat": 10
    },
    {
        "meal_type": "lunch",
        "foods": ["chicken breast 150g", "rice 100g"],
        "calories": 450,
        "protein": 40,
        "carbs": 50,
        "fat": 8
    }
]
```

---

### 💧 WATER_LOGS TABLE

**Purpose**: Track hydration - simple daily water intake

```sql
Column              Type            Description
─────────────────────────────────────────────────────────
id                  BIGINT          Primary key
user_id             BIGINT FK       User reference
logged_on           DATE            Date
liters              DECIMAL(4,2)    Water consumed (liters)
created_at          TIMESTAMP       Created
updated_at          TIMESTAMP       Updated
```

---

### 📋 HABIT_LOGS TABLE

**Purpose**: Track daily habits - exercise, meditation, etc.

```sql
Column              Type            Description
─────────────────────────────────────────────────────────
id                  BIGINT          Primary key
user_id             BIGINT FK       User reference
logged_on           DATE            Date
habit               VARCHAR         Habit name (exercise, meditation, etc)
completed           BOOLEAN         Did they do it? (true/false)
score               TINYINT         Optional score (1-10)
created_at          TIMESTAMP       Created
updated_at          TIMESTAMP       Updated
```

**Example Queries**:

```php
// 30-day habit streak for "exercise"
$exerciseLogs = HabitLog::where('habit', 'exercise')
    ->whereDate('logged_on', '>=', now()->subDays(30))
    ->where('completed', true)
    ->count();
```

---

### 📷 PROGRESS_PHOTOS TABLE

**Purpose**: Store before/after photos for visual motivation

```sql
Column              Type            Description
─────────────────────────────────────────────────────────
id                  BIGINT          Primary key
user_id             BIGINT FK       User reference
path                VARCHAR         File path or URL
logged_on           DATE            When photo was taken
visibility          VARCHAR         private/public/friends
created_at          TIMESTAMP       Created
updated_at          TIMESTAMP       Updated
```

**Storage**: `/storage/app/progress-photos/{user_id}/{filename}`

---

### 🏆 MILESTONES TABLE

**Purpose**: Track achievements and celebrate progress

```sql
Column              Type            Description
─────────────────────────────────────────────────────────
id                  BIGINT          Primary key
user_id             BIGINT FK       User reference
title               VARCHAR         Milestone title
description         TEXT            Description
unlocked_on         DATE            When achieved
meta                JSON            Additional data
created_at          TIMESTAMP       Created
updated_at          TIMESTAMP       Updated
```

**Example Milestones**:

```json
{
    "title": "First 5kg Lost",
    "unlocked_on": "2026-05-15",
    "meta": {
        "type": "weight_loss",
        "threshold_kg": 5.0,
        "icon": "🎉",
        "reward": "earned_badge"
    }
}
```

---

### 🍽️ DIET_PLANS TABLE

**Purpose**: Weekly meal plans for users

```sql
Column                      Type            Description
─────────────────────────────────────────────────────────────
id                          BIGINT          Primary key
user_id                     BIGINT FK       User reference
name                        VARCHAR         Plan name (Weekly Plan 1, etc)
status                      VARCHAR         draft/active/completed/archived
starts_on                   DATE            Plan start date
ends_on                     DATE            Plan end date
daily_calorie_target        SMALLINT        Daily calorie goal
protein_target_g            SMALLINT        Daily protein goal (g)
carb_target_g               SMALLINT        Daily carb goal (g)
fat_target_g                SMALLINT        Daily fat goal (g)
grocery_payload             JSON            Generated grocery list
notes                       TEXT            Plan notes/tips
created_at                  TIMESTAMP       Created
updated_at                  TIMESTAMP       Updated
```

---

### 🍴 DIET_PLAN_MEALS TABLE

**Purpose**: Individual meals within a diet plan

```sql
Column                      Type            Description
─────────────────────────────────────────────────────────────
id                          BIGINT          Primary key
diet_plan_id                BIGINT FK       Reference to diet_plans
planned_for                 DATE            Day of meal
meal_type                   VARCHAR         breakfast/lunch/dinner/snack
title                       VARCHAR         Meal name
description                 TEXT            Meal description
target_calories             SMALLINT        Calorie goal for meal
protein_g                   SMALLINT        Protein target (g)
carb_g                      SMALLINT        Carb target (g)
fat_g                       SMALLINT        Fat target (g)
created_at                  TIMESTAMP       Created
updated_at                  TIMESTAMP       Updated
```

---

### 🎨 RECIPES TABLE

**Purpose**: Recipe library - AI-generated or user-saved

```sql
Column                      Type            Description
─────────────────────────────────────────────────────────────
id                          BIGINT          Primary key
user_id                     BIGINT FK       Creator (nullable - system recipes)
title                       VARCHAR         Recipe name
summary                     TEXT            Short description
meal_type                   VARCHAR         breakfast/lunch/dinner/snack
cuisine                     VARCHAR         Italian/Asian/etc
servings                    TINYINT         Number of servings
prep_minutes                SMALLINT        Prep time (minutes)
cook_minutes                SMALLINT        Cook time (minutes)
total_calories              SMALLINT        Total calories for recipe
protein_g                   SMALLINT        Total protein (g)
carb_g                      SMALLINT        Total carbs (g)
fat_g                       SMALLINT        Total fat (g)
ingredients                 JSON            Ingredient list
steps                       JSON            Cooking instructions
nutrition_payload           JSON            Detailed nutrition
substitutions               JSON            Healthy swaps
tags                        JSON            Tags (quick, easy, vegan, etc)
source                      VARCHAR         ai/user/system
created_at                  TIMESTAMP       Created
updated_at                  TIMESTAMP       Updated
```

**ingredients JSON Example**:

```json
[
    {
        "item": "chicken breast",
        "quantity": 2,
        "unit": "pieces",
        "calories": 330,
        "protein": 60,
        "carbs": 0,
        "fat": 7
    },
    {
        "item": "olive oil",
        "quantity": 1,
        "unit": "tbsp",
        "calories": 119,
        "protein": 0,
        "carbs": 0,
        "fat": 14
    }
]
```

**steps JSON Example**:

```json
[
    { "step": 1, "instruction": "Preheat oven to 400°F" },
    { "step": 2, "instruction": "Season chicken with salt and pepper" },
    {
        "step": 3,
        "instruction": "Bake for 25-30 minutes until internal temp reaches 165°F"
    }
]
```

---

### 🤖 RECIPE_GENERATIONS TABLE

**Purpose**: Track AI recipe generation requests and results

```sql
Column                      Type            Description
─────────────────────────────────────────────────────────────
id                          BIGINT          Primary key
user_id                     BIGINT FK       User who requested
recipe_id                   BIGINT FK       Generated recipe (nullable)
request_payload             JSON            What user asked for
response_payload            JSON            AI response
model                       VARCHAR         Which AI model used
status                      VARCHAR         queued/processing/completed/failed
generated_at                TIMESTAMP       When generation happened
created_at                  TIMESTAMP       Created
updated_at                  TIMESTAMP       Updated
```

**request_payload Example**:

```json
{
    "dietary_preference": "vegetarian",
    "calories": 500,
    "allergies": ["nuts"],
    "available_ingredients": ["rice", "beans", "tomatoes"],
    "cooking_time_minutes": 30,
    "cuisine": "Mexican"
}
```

---

### 📌 RECIPE_BOOKMARKS TABLE

**Purpose**: Users saving favorite recipes

```sql
Column              Type            Description
─────────────────────────────────────────────────────────
id                  BIGINT          Primary key
user_id             BIGINT FK       User who saved
recipe_id           BIGINT FK       Recipe reference
created_at          TIMESTAMP       When bookmarked
updated_at          TIMESTAMP       Updated

UNIQUE(user_id, recipe_id)  ← Can't bookmark same recipe twice
```

---

### 🔑 USER_AI_SETTINGS TABLE

**Purpose**: Store OpenRouter API configuration per user

```sql
Column                      Type            Description
─────────────────────────────────────────────────────────────
id                          BIGINT          Primary key
user_id                     BIGINT FK       User reference (UNIQUE)
openrouter_api_key          VARCHAR         User's API key (encrypted)
openrouter_model            VARCHAR         Model preference
monthly_recipe_limit        SMALLINT        Recipes allowed/month
recipes_generated_this_month SMALLINT        Count this month
created_at                  TIMESTAMP       Created
updated_at                  TIMESTAMP       Updated
```

---

### 🛒 USER_PANTRY_ITEMS TABLE

**Purpose**: User's ingredient inventory for meal planning

```sql
Column              Type            Description
─────────────────────────────────────────────────────────
id                  BIGINT          Primary key
user_id             BIGINT FK       User reference
ingredient          VARCHAR         Ingredient name
quantity            DECIMAL(8,2)    Amount available
unit                VARCHAR         kg/grams/cups/pieces
expires_on          DATE            Expiration date
created_at          TIMESTAMP       Created
updated_at          TIMESTAMP       Updated
```

---

## QUICK REFERENCE: COMMON QUERIES

### Get User's Current Status

```php
$user = auth()->user()->loadMissing([
    'profile',
    'healthProfile',
    'goalProfile',
]);

// User's current stats
$bmi = $user->profile->calculateBMI();
$daysToGoal = $user->profile->daysUntilGoal();
$caloriesRemaining = $user->goalProfile->daily_calorie_target
    - $user->todayCalorieLog()->consumed_calories;
```

### Get Week's Weight Progress

```php
$weekLogs = auth()->user()
    ->weightLogs()
    ->whereBetween('logged_on', [
        now()->startOfWeek(),
        now()->endOfWeek()
    ])
    ->orderBy('logged_on')
    ->get();

$firstWeight = $weekLogs->first()->weight_kg;
$lastWeight = $weekLogs->last()->weight_kg;
$weekLoss = $firstWeight - $lastWeight;
```

### Get Active Diet Plan Meals

```php
$activePlan = auth()->user()
    ->dietPlans()
    ->where('status', 'active')
    ->first();

$todayMeals = $activePlan->meals()
    ->where('planned_for', today())
    ->get();
```

### Find Bookmarked Recipes

```php
$bookmarks = auth()->user()
    ->bookmarkedRecipes()  // Through recipe_bookmarks
    ->paginate(12);
```

---

## ENUMS (Constants)

### UserRole

```php
enum UserRole {
    User
    Admin
}
```

### ActivityLevel

```php
Sedentary, Light, Moderate, VeryActive
```

### Gender

```php
Male, Female, Other
```

### GoalType

```php
FatLoss, MuscleGain, Maintenance
```

### GoalPace

```php
Fast, Sustainable
```

---

## USEFUL CALCULATIONS

### BMI

```php
$bmi = $weight_kg / (($height_cm / 100) ** 2);
```

### Daily Calorie Needs (Mifflin-St Jeor)

```php
// For men
$bmr = (10 * weight) + (6.25 * height) - (5 * age) + 5;

// For women
$bmr = (10 * weight) + (6.25 * height) - (5 * age) - 161;

$tdee = $bmr * activity_factor;
```

### Macro Distribution

```php
// Standard split: 40% protein, 40% carbs, 20% fat
$protein_calories = calories * 0.40;  // 4 cal/g → protein_g
$carb_calories = calories * 0.40;     // 4 cal/g → carb_g
$fat_calories = calories * 0.20;      // 9 cal/g → fat_g
```

---

This schema is production-ready and optimized for the weight loss platform. All columns are properly typed and indexed for performance.
