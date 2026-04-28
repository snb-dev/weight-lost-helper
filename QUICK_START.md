# 🚀 Quick Start Reference Card

**Print this or keep handy while coding**

---

## SETUP (One-Time)

```bash
# Navigate to project
cd weight-loss-helper

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure PHP for CLI (IMPORTANT on Windows):
php -c "C:/Users/snb10/Desktop/Codex test/php.ini" artisan migrate

# Run migrations
php -c "C:/Users/snb10/Desktop/Codex test/php.ini" artisan migrate
```

---

## DAILY DEVELOPMENT

### Start Dev Servers (recommended way)

**Option 1** - Composer script (all in one):

```bash
composer run dev
```

**Option 2** - Manual (3 terminals):

**Terminal 1** - CSS/JS compilation:

```bash
npm run dev
```

**Terminal 2** - Laravel server:

```bash
php artisan serve
```

**Terminal 3** - Queue (for background jobs):

```bash
php artisan queue:listen --tries=1 --timeout=0
```

**Access**: http://localhost:8000

---

## CREATE LIVEWIRE COMPONENT

When building a new feature:

```bash
# Create component (choose one)
php artisan make:livewire Forms/FeatureName        # For forms
php artisan make:livewire Pages/FeatureName        # For pages
php artisan make:livewire FeatureName              # Generic

# Then:
# 1. Edit app/Livewire/YourComponent.php
# 2. Create resources/views/livewire/your-component.blade.php
# 3. Add route in routes/web.php
# 4. Test at http://localhost:8000/your-route
```

---

## FORMS WITH LIVEWIRE

```php
// app/Livewire/Forms/MyForm.php
<?php
namespace App\Livewire\Forms;

use Livewire\Component;
use Livewire\Attributes\Validate;

class MyForm extends Component {
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|email')]
    public $email = '';

    public function submit() {
        $this->validate();

        // Save to database
        MyModel::create([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        // Redirect or reset
        $this->redirect('/dashboard', navigate: true);
    }

    public function render() {
        return view('livewire.forms.my-form');
    }
}
```

---

## BLADE VIEW TEMPLATE

```blade
<form wire:submit="submit" class="space-y-4">
    <!-- Text input with error -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">
            Name
        </label>
        <input
            wire:model="name"
            type="text"
            id="name"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"
        />
        @error('name') <span class="text-red-600">{{ $message }}</span> @enderror
    </div>

    <!-- Email input -->
    <div>
        <label for="email">Email</label>
        <input
            wire:model="email"
            type="email"
            id="email"
            class="block w-full px-3 py-2 border border-gray-300 rounded-md"
        />
        @error('email') <span class="text-red-600">{{ $message }}</span> @enderror
    </div>

    <!-- Submit button -->
    <button
        type="submit"
        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
        wire:loading.attr="disabled"
    >
        <span wire:loading.remove>Submit</span>
        <span wire:loading>Submitting...</span>
    </button>
</form>
```

---

## ADD ROUTE

```php
// routes/web.php
use App\Http\Controllers\MyController;

// For Livewire component
Route::get('/my-page', \App\Livewire\MyComponent::class)
    ->name('my.page')
    ->middleware(['auth', 'verified']);

// For controller
Route::get('/my-page', MyController::class)
    ->name('my.page')
    ->middleware(['auth']);
```

---

## COMMON BLADE SNIPPETS

### Alert/Toast

```blade
<!-- Success message -->
@if (session('success'))
    <div class="bg-green-100 text-green-800 p-4 rounded">
        {{ session('success') }}
    </div>
@endif

<!-- Error message -->
@if ($errors->any())
    <div class="bg-red-100 text-red-800 p-4 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

### Conditional Display

```blade
<!-- If authenticated -->
@auth
    <p>Welcome {{ auth()->user()->name }}</p>
@endauth

<!-- If guest -->
@guest
    <a href="/login">Login</a>
@endguest
```

### Loops

```blade
<!-- For each -->
@foreach ($items as $item)
    <div>{{ $item->name }}</div>
@endforeach

<!-- If empty -->
@forelse ($items as $item)
    <div>{{ $item->name }}</div>
@empty
    <p>No items found</p>
@endforelse
```

---

## TAILWIND CSS COMMON CLASSES

```html
<!-- Spacing -->
class="p-4 m-2 mt-4 mb-2 px-3 py-2"

<!-- Colors -->
class="text-blue-600 bg-gray-100 border-2 border-red-500"

<!-- Layout -->
class="flex justify-center items-center gap-4" class="grid grid-cols-3 gap-4"

<!-- Responsive -->
class="block md:flex lg:grid" class="text-sm md:text-base lg:text-lg"

<!-- Hover/Focus -->
class="hover:bg-blue-700 focus:outline-none focus:ring-2"

<!-- Common component -->
<button
    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
>
    Click me
</button>

<input
    type="text"
    class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
/>
```

---

## DATABASE QUERIES

### In Livewire Component

```php
// Get all
$items = MyModel::all();

// Get with relationships
$user = User::with('profile', 'goalProfile')->find($id);

// Get current user's data
$profile = auth()->user()->profile;
$logs = auth()->user()->weightLogs()->latest()->get();

// Create
MyModel::create([
    'name' => 'value',
    'user_id' => auth()->id(),
]);

// Update
$model->update(['name' => 'new value']);

// Delete
$model->delete();

// Pagination
$items = MyModel::paginate(15);
```

### In View

```blade
{{ $user->profile->current_weight_kg }}
{{ $user->goalProfile->daily_calorie_target }}
@foreach ($user->weightLogs as $log)
    {{ $log->logged_on }}: {{ $log->weight_kg }}kg
@endforeach
```

---

## DEBUGGING

```bash
# Check migrations status
php -c "C:/Users/snb10/Desktop/Codex test/php.ini" artisan migrate:status

# Run specific migration
php -c "C:/Users/snb10/Desktop/Codex test/php.ini" artisan migrate --path=database/migrations/file.php

# Tinker (interactive shell)
php -c "C:/Users/snb10/Desktop/Codex test/php.ini" artisan tinker
# Then: User::with('profile')->first()

# Clear cache
php artisan cache:clear
php artisan config:clear

# Check if it compiles
php artisan optimize
```

---

## LIVEWIRE EVENTS & COMMUNICATION

```php
// Dispatch event
$this->dispatch('weightLogged', weight: 75.5);

// Listen for event
#[On('weightLogged')]
public function refreshChart($weight) {
    // Update component
}

// Redirect in component
$this->redirect('/dashboard', navigate: true);

// Session message
session()->flash('success', 'Saved successfully');
```

---

## CHART.JS QUICK START

```html
<!-- In blade view -->
<canvas id="myChart"></canvas>

<script>
    const ctx = document.getElementById("myChart").getContext("2d");
    const chart = new Chart(ctx, {
        type: "line",
        data: {
            labels: ["Jan", "Feb", "Mar"],
            datasets: [
                {
                    label: "Weight",
                    data: [80, 79, 78],
                    borderColor: "rgb(59, 130, 246)",
                    backgroundColor: "rgba(59, 130, 246, 0.1)",
                    tension: 0.1,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
            },
        },
    });
</script>
```

---

## LIVEWIRE FORM VALIDATION

```php
#[Validate('required|string|max:255')]
public $name = '';

#[Validate('required|numeric|min:0|max:300')]
public $weight = '';

#[Validate('required|email|unique:users')]
public $email = '';

#[Validate('required|date|after:today')]
public $target_date = '';

public function submit() {
    $this->validate();  // Validate all properties
    // Save...
}
```

---

## FILE PATHS TO REMEMBER

```
app/Livewire/          ← Your components
resources/views/livewire/ ← Component views
routes/web.php         ← Routes
database/migrations/   ← Already complete
app/Models/            ← Models (all exist)
app/Services/          ← Business logic
config/                ← Configuration
.env                   ← Environment variables
```

---

## MOBILE RESPONSIVE CHECKLIST

- [ ] Desktop: Full width features
- [ ] Tablet (768px): Stack items 2-wide
- [ ] Mobile (< 640px): Stack items single column
- [ ] Touch targets: Min 44x44px
- [ ] Text: Readable without zoom
- [ ] Images: Scale responsively
- [ ] Test on actual phone!

**Tailwind breakpoints**:

```
sm: 640px   md: 768px   lg: 1024px   xl: 1280px
```

---

## GIT WORKFLOW

```bash
# Check status
git status

# Stage changes
git add .

# Commit
git commit -m "Build onboarding form"

# Push
git push origin main

# Pull latest
git pull origin main
```

---

## PERFORMANCE TIPS

✅ **DO**:

- Use `with()` for eager loading relationships
- Index frequently queried columns
- Cache expensive calculations
- Paginate large result sets
- Use `limit()` on queries

❌ **DON'T**:

- N+1 queries in loops
- Fetch all records when you need 10
- Calculate on every page load (cache instead)
- Store sensitive data in logs
- Commit secrets to git

---

## USEFUL LINKS

- **Laravel Docs**: https://laravel.com/docs
- **Livewire Docs**: https://livewire.laravel.com/docs
- **Tailwind CSS**: https://tailwindcss.com/docs
- **Chart.js**: https://www.chartjs.org/docs
- **This Project Docs**: See ARCHITECTURE_ANALYSIS.md

---

## BEFORE YOU PUSH

```bash
# 1. Test locally
npm run dev
php artisan serve
# Visit http://localhost:8000

# 2. Check for errors
php artisan optimize

# 3. Commit
git add .
git commit -m "descriptive message"

# 4. Push
git push origin main
```

---

**Bookmark this page. You'll need it!**

Last Updated: April 26, 2026
