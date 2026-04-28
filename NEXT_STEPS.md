# NEXT STEPS - Quick Start Implementation Guide

> **Generated**: April 26, 2026  
> **Status**: Ready for Phase 2 development  
> **Priority**: Build UI/UX Components

---

## IMMEDIATE ACTION ITEMS (This Week)

### ✅ HAVE COMPLETED:

1. Full database schema with 14 production-ready tables
2. All Eloquent models with relationships
3. Authentication system (Breeze)
4. Core nutrition calculation services
5. Basic route structure
6. Environment configuration

---

## WHAT TO BUILD NEXT (Prioritized)

### 🎯 PRIORITY 1: Onboarding Flow (Start Here!)

**Time**: 8-10 hours  
**Impact**: Critical - Users can't use app without onboarding

**What needs to be built**:

1. **Livewire Form Component** (`app/Livewire/Forms/OnboardingForm.php`)

    ```php
    namespace App\Livewire\Forms;
    use Livewire\Component;

    class OnboardingForm extends Component {
        // Step 1: Basic Info (Age, Gender, Height, Weight)
        // Step 2: Goals (Goal Weight, Timeline, Activity)
        // Step 3: Health (Dietary Prefs, Allergies, Conditions)
        // Step 4: Lifestyle (Budget, Cooking Skill, Schedule)
        // Step 5: Confirmation

        public $step = 1;
        public $age, $gender, $height, $currentWeight;
        // ... more properties

        public function nextStep() {
            // Validate current step
            // Move to next step
        }

        public function submit() {
            // Save to Profile, HealthProfile, GoalProfile
            // Redirect to dashboard
        }
    }
    ```

2. **Livewire View** (`resources/views/livewire/onboarding-form.blade.php`)
    - Multi-step form with progress indicator
    - Validation display
    - Mobile-responsive design

3. **Update Route**:
    ```php
    // routes/web.php
    Route::get('/onboarding', \App\Livewire\Forms\OnboardingForm::class)->middleware(['auth']);
    ```

**Deliverable**: Users can complete onboarding and get personalized calculations

---

### 🎯 PRIORITY 2: Dashboard (Do Next)

**Time**: 6-8 hours  
**Impact**: High - Core user hub

**Components**:

1. **Stats Cards**
    - Current weight
    - Goal weight
    - BMI
    - Days until goal

2. **Activity Charts**
    - Weight trend (line chart)
    - Calorie vs target (bar chart)
    - Macro breakdown (donut chart)

3. **Recent Logs**
    - Last 7 weight entries
    - Today's calorie count
    - Water intake progress

4. **Quick Actions**
    - Log weight
    - Log meal
    - Generate recipe
    - View meal plan

**Use Chart.js** for visualizations:

```bash
npm install chart.js
```

**Livewire Component Example**:

```php
// app/Livewire/Dashboard.php
class Dashboard extends Component {
    #[On('weightLogged')]
    public function refreshStats() {
        // Recalculate and update charts
    }

    public function render() {
        return view('livewire.dashboard', [
            'stats' => $this->calculateStats(),
            'chartData' => $this->getChartData(),
        ]);
    }
}
```

---

### 🎯 PRIORITY 3: Weight Tracking

**Time**: 8-10 hours  
**Impact**: High - Core feature

**Components**:

1. **Weight Logger Form**
    - Date picker
    - Weight input
    - Notes textarea
    - Submit

2. **Weight History**
    - Sortable table
    - Pagination
    - Edit/delete buttons
    - Export to CSV

3. **Progress Chart**
    - Visual weight trend
    - Goal line indicator
    - Milestone markers

**Models Already Exist**:

- `WeightLog` model
- Controller method: `StoreWeightLogController`

**Livewire Component**:

```php
// app/Livewire/WeightTracker.php
class WeightTracker extends Component {
    public $weight, $date, $notes;
    public $logs;

    public function logWeight() {
        WeightLog::create([
            'user_id' => auth()->id(),
            'logged_on' => $this->date,
            'weight_kg' => $this->weight,
            'bmi' => calculateBMI($this->weight, auth()->user()->profile->height_cm),
            'notes' => $this->notes,
        ]);

        $this->dispatch('weightLogged');
    }
}
```

---

### 🎯 PRIORITY 4: Meal/Calorie Tracking

**Time**: 10-12 hours  
**Impact**: High - Core feature

**Components**:

1. **Meal Logger**
    - Meal type (breakfast/lunch/dinner/snack)
    - Food/recipe selector
    - Quantity
    - Calorie/macro calculation
    - Submit

2. **Daily Summary**
    - Total calories logged
    - Remaining calories
    - Macro breakdown
    - vs target comparison

3. **History & Analytics**
    - Weekly calorie trend
    - Most logged foods
    - Macro pie chart

**Important**: Need food database integration
Options:

- Use USDA FoodData Central API (free)
- Manual recipe database
- OpenRouter AI to estimate nutrition

---

### 🎯 PRIORITY 5: User Profile/Settings

**Time**: 6-8 hours  
**Impact**: Medium - Important for data integrity

**Sections**:

1. **Personal Information**
    - Edit age, gender, height, weight
    - Update goal weight, timeline
    - Activity level

2. **Dietary Preferences**
    - Dietary restrictions
    - Allergies
    - Foods to avoid
    - Cuisine preferences
    - Budget level

3. **Pantry Items** (Ingredient Inventory)
    - Add/remove ingredients
    - Quantity tracker
    - Expiration dates

4. **AI Settings**
    - OpenRouter API key
    - Model selection
    - Recipe preferences

---

### 🎯 PRIORITY 6: Navigation & Layout

**Time**: 10-12 hours  
**Impact**: Critical - Touch every page

**Components**:

1. **Main Layout**
    - Responsive navigation header
    - Sidebar (desktop) / mobile menu
    - Active link indicators
    - User dropdown

2. **Mobile Optimization**
    - Hamburger menu
    - Bottom navigation
    - Touch-friendly buttons
    - Typography scaling

**Tailwind CSS Classes to Use**:

```html
<!-- Navigation -->
<nav class="hidden md:flex bg-blue-600 text-white">
    <a href="/dashboard" class="px-4 py-2">Dashboard</a>
    <!-- More links -->
</nav>

<!-- Mobile Menu -->
<nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t">
    <!-- Mobile nav items -->
</nav>
```

---

## DATABASE MIGRATION PLAN

### When to Migrate from SQLite to PostgreSQL:

**Option A** (Recommended for MVP):

- Use SQLite for development (it's already setup)
- Switch to PostgreSQL only when deploying to production
- Use `.env` to select database dynamically

**Option B** (If want to test PostgreSQL locally):

```bash
# 1. Create Supabase account get connection string

# 2. Update .env
DB_CONNECTION=pgsql
DB_HOST=...supabase...
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=...

# 3. Run migrations
php artisan migrate
```

**Recommended**: Keep using SQLite locally for development speed, migrate to PostgreSQL in production only.

---

## OPENROUTER API SETUP (For Phase 3)

### When to Implement: After UI complete

**Steps**:

1. **Get API Key**:
    - Visit openrouter.ai
    - Sign up (free)
    - Generate API key
    - Add to `.env`: `OPENROUTER_API_KEY=...`

2. **Create Service**:

    ```php
    // app/Services/OpenRouter/RecipeGenerationService.php
    namespace App\Services\OpenRouter;

    class RecipeGenerationService {
        protected $apiKey;
        protected $model = 'qwen2.5-72b-gpt-1.5b-32k-vision';

        public function generateRecipe(User $user, array $preferences) {
            $prompt = $this->buildPrompt($user, $preferences);
            $response = $this->callApi($prompt);
            return $this->parseRecipe($response);
        }

        private function buildPrompt() {
            // Build detailed recipe prompt with user preferences
        }

        private function callApi($prompt) {
            $response = Http::withHeader('Authorization', 'Bearer ' . $this->apiKey)
                ->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a professional recipe creator...'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);
            return $response->json();
        }
    }
    ```

3. **Create Controller**:
    ```php
    // app/Http/Controllers/GenerateRecipeController.php
    public function store(Request $request) {
        $service = new RecipeGenerationService();
        $recipe = $service->generateRecipe(auth()->user(), $request->all());

        Recipe::create($recipe);
        return redirect()->route('recipes.show', $recipe)->with('success', 'Recipe created!');
    }
    ```

---

## TOOLING & LIBRARIES TO INSTALL

```bash
# Charts.js for visualizations
npm install chart.js chartjs-adapter-date-fns

# Data tables
npm install datatables.net

# For future file uploads
npm install dropzone

# For API requests (already included in Laravel)
# Just use: Http::get(...) in your code
```

---

## TESTING YOUR PROGRESS

### After Each Component Built:

```bash
# Start dev server
npm run dev

# In another terminal:
php artisan serve

# Access: http://localhost:8000
# Login with test credentials (or register)

# Check:
1. Component loads without errors
2. Form validation shows messages
3. Data saves to database
4. Mobile view responsive
5. No console errors (F12)
```

---

## COMMON PITFALLS TO AVOID

❌ **Don't**:

- Skip validation (always validate)
- Hardcode user IDs (use `auth()->id()`)
- Forget mobile responsiveness
- Store passwords unhashed
- Deploy API keys to GitHub
- Forget to escape Blade output

✅ **Do**:

- Use Livewire validation: `#[Validate('required...')]`
- Use DB::transaction() for multi-step operations
- Test on mobile during development
- Use environment variables for secrets
- Write meaningful error messages
- Add loading states to buttons

---

## QUICK DEBUGGING TIPS

```bash
# Check what's happening in Livewire
# Add dd() in component methods
php artisan tinker
# Then test models: User::with('profile')->first()

# Check migrations status
php artisan migrate:status

# View database (with correct php.ini):
php -c "C:/Users/snb10/Desktop/Codex test/php.ini" artisan tinker

# Clear application cache
php artisan cache:clear
php artisan config:clear
```

---

## SUCCESS CRITERIA FOR PHASE 2

Before moving to AI recipe generation, you should have:

- [ ] Users can register & complete onboarding
- [ ] Dashboard displays personalized data
- [ ] Weight log form works and saves data
- [ ] Weight history visible with pagination
- [ ] All views responsive on mobile
- [ ] No console errors
- [ ] All forms validate properly
- [ ] User can edit profile/settings
- [ ] Navigation works seamlessly

---

## ESTIMATED EFFORT BREAKDOWN

| Component         | Hours     | Status         |
| ----------------- | --------- | -------------- |
| Onboarding        | 8-10      | 🔴 Not Started |
| Dashboard         | 6-8       | 🔴 Not Started |
| Weight Tracking   | 8-10      | 🔴 Not Started |
| Meal Tracking     | 10-12     | 🔴 Not Started |
| Profile/Settings  | 6-8       | 🔴 Not Started |
| Navigation/Layout | 10-12     | 🔴 Not Started |
| Error Handling    | 6-8       | 🔴 Not Started |
| **TOTAL PHASE 2** | **60-80** | 🔄 In Progress |

---

## RESOURCES & REFERENCES

### Laravel/Livewire Documentation:

- Laravel Blade: https://laravel.com/docs/blade
- Livewire Components: https://livewire.laravel.com/docs/components
- Form Validation: https://laravel.com/docs/validation

### UI/UX:

- Tailwind CSS: https://tailwindcss.com/docs
- Headless UI (components): https://headlessui.com
- Hero Icons (svg icons): https://heroicons.com

### Charts:

- Chart.js: https://www.chartjs.org/docs/latest/
- Chart.js Laravel wrapper: https://github.com/coderello/laravel-chartjs

### AI/API:

- OpenRouter Docs: https://openrouter.ai/docs
- Laravel HTTP Client: https://laravel.com/docs/http-client

---

## NEXT SESSION AGENDA

1. [ ] Create Livewire onboarding form component
2. [ ] Build dashboard view with stats
3. [ ] Implement weight tracking form
4. [ ] Add Chart.js for visualizations
5. [ ] Style with Tailwind CSS
6. [ ] Test mobile responsiveness

---

**You're ready to start building! Begin with the onboarding form - it's the entry point for all users.**

Good luck! 🚀
