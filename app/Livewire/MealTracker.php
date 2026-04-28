<?php

namespace App\Livewire;

use App\Models\DietPlanMeal;
use Livewire\Component;
use Livewire\WithPagination;

class MealTracker extends Component
{
    use WithPagination;

    #[\Livewire\Attributes\Validate('required|string|max:255')]
    public $meal_name = '';

    #[\Livewire\Attributes\Validate('required|string|in:breakfast,snack,lunch,dinner')]
    public $meal_type = '';

    #[\Livewire\Attributes\Validate('nullable|numeric|min:0|max:3000')]
    public $calories = '';

    #[\Livewire\Attributes\Validate('nullable|numeric|min:0|max:300')]
    public $protein_g = '';

    #[\Livewire\Attributes\Validate('nullable|numeric|min:0|max:300')]
    public $carbs_g = '';

    #[\Livewire\Attributes\Validate('nullable|numeric|min:0|max:300')]
    public $fat_g = '';

    #[\Livewire\Attributes\Validate('nullable|string|max:500')]
    public $notes = '';

    #[\Livewire\Attributes\Validate('required|date|before_or_equal:today')]
    public $logged_on = '';

    public $showForm = false;
    public $editingId = null;
    public $stats = [
        'totalCalories' => 0,
        'totalProtein' => 0,
        'totalCarbs' => 0,
        'totalFat' => 0,
        'mealCount' => 0,
    ];

    public function mount()
    {
        $this->logged_on = today()->toDateString();
        $this->loadStats();
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function loadStats()
    {
        $user = auth()->user();
        $todayMeals = DietPlanMeal::where('user_id', $user->id)
            ->whereDate('logged_on', today())
            ->get();

        $this->stats = [
            'totalCalories' => (int)$todayMeals->sum('calories'),
            'totalProtein' => round($todayMeals->sum('protein_g'), 1),
            'totalCarbs' => round($todayMeals->sum('carbs_g'), 1),
            'totalFat' => round($todayMeals->sum('fat_g'), 1),
            'mealCount' => $todayMeals->count(),
        ];
    }

    public function submit()
    {
        $this->validate();

        $user = auth()->user();

        if ($this->editingId) {
            $meal = DietPlanMeal::find($this->editingId);
            $meal->update([
                'meal_name' => $this->meal_name,
                'meal_type' => $this->meal_type,
                'calories' => $this->calories ?: null,
                'protein_g' => $this->protein_g ?: null,
                'carbs_g' => $this->carbs_g ?: null,
                'fat_g' => $this->fat_g ?: null,
                'notes' => $this->notes ?: null,
                'logged_on' => $this->logged_on,
            ]);
            $message = 'Meal updated successfully!';
        } else {
            DietPlanMeal::create([
                'user_id' => $user->id,
                'meal_name' => $this->meal_name,
                'meal_type' => $this->meal_type,
                'calories' => $this->calories ?: null,
                'protein_g' => $this->protein_g ?: null,
                'carbs_g' => $this->carbs_g ?: null,
                'fat_g' => $this->fat_g ?: null,
                'notes' => $this->notes ?: null,
                'logged_on' => $this->logged_on,
            ]);
            $message = 'Meal logged successfully!';
        }

        session()->flash('success', $message);
        $this->resetForm();
        $this->loadStats();
    }

    public function edit($id)
    {
        $meal = DietPlanMeal::find($id);
        $this->editingId = $id;
        $this->meal_name = $meal->meal_name;
        $this->meal_type = $meal->meal_type;
        $this->calories = $meal->calories;
        $this->protein_g = $meal->protein_g;
        $this->carbs_g = $meal->carbs_g;
        $this->fat_g = $meal->fat_g;
        $this->notes = $meal->notes;
        $this->logged_on = $meal->logged_on;
        $this->showForm = true;
    }

    public function delete($id)
    {
        DietPlanMeal::find($id)->delete();
        session()->flash('success', 'Meal deleted successfully!');
        $this->loadStats();
    }

    public function resetForm()
    {
        $this->reset(['meal_name', 'meal_type', 'calories', 'protein_g', 'carbs_g', 'fat_g', 'notes', 'editingId', 'showForm']);
        $this->logged_on = today()->toDateString();
    }

    public function render()
    {
        $user = auth()->user();
        $meals = DietPlanMeal::where('user_id', $user->id)
            ->whereDate('logged_on', $this->logged_on)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.meal-tracker', [
            'meals' => $meals,
        ]);
    }
}
