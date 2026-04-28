<?php

namespace App\Livewire;

use App\Models\Profile;
use App\Models\HealthProfile;
use App\Models\GoalProfile;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Validate;
use Livewire\Component;

class OnboardingForm extends Component
{
    public $step = 1;
    
    // Step 1: Basic Info
    #[Validate('required|integer|min:18|max:120')]
    public $age = '';
    
    #[Validate('required|in:Male,Female,Other')]
    public $gender = '';
    
    #[Validate('required|integer|min:100|max:300')]
    public $height_cm = '';
    
    #[Validate('required|numeric|min:30|max:500')]
    public $current_weight_kg = '';
    
    // Step 2: Goals
    #[Validate('required|numeric|min:30|max:300')]
    public $goal_weight_kg = '';
    
    #[Validate('required|date|after:today')]
    public $target_date = '';
    
    #[Validate('required|in:Sedentary,Light,Moderate,VeryActive')]
    public $activity_level = '';
    
    // Step 3: Health
    #[Validate('required')]
    public $dietary_preference = '';
    
    public $allergies = '';
    
    public $foods_to_avoid = '';
    
    public $medical_conditions = '';
    
    // Step 4: Lifestyle
    #[Validate('required|in:Beginner,Intermediate,Advanced')]
    public $cooking_skill_level = '';
    
    #[Validate('required|in:Low,Medium,High')]
    public $food_budget_level = '';
    
    public $daily_schedule = '';
    
    public $stress_level = 5;
    
    public $water_intake_liters = 2.0;
    
    public $sleep_hours = 7.0;
    
    public $goal_type = 'fat_loss';
    
    public $goal_pace = 'sustainable';

    public function validateStep($stepNum)
    {
        $rules = [];
        
        if ($stepNum >= 1) {
            $rules = array_merge($rules, [
                'age' => 'required|integer|min:18|max:120',
                'gender' => 'required|in:Male,Female,Other',
                'height_cm' => 'required|integer|min:100|max:300',
                'current_weight_kg' => 'required|numeric|min:30|max:500',
            ]);
        }
        
        if ($stepNum >= 2) {
            $rules = array_merge($rules, [
                'goal_weight_kg' => 'required|numeric|min:30|max:300',
                'target_date' => 'required|date|after:today',
                'activity_level' => 'required|in:Sedentary,Light,Moderate,VeryActive',
            ]);
        }
        
        if ($stepNum >= 3) {
            $rules = array_merge($rules, [
                'dietary_preference' => 'required',
            ]);
        }
        
        if ($stepNum >= 4) {
            $rules = array_merge($rules, [
                'cooking_skill_level' => 'required|in:Beginner,Intermediate,Advanced',
                'food_budget_level' => 'required|in:Low,Medium,High',
            ]);
        }
        
        return $this->validate($rules);
    }

    public function nextStep()
    {
        $this->validateStep($this->step);
        $this->step++;
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function submit()
    {
        $this->validateStep(4);
        
        $user = auth()->user();
        
        // Create/Update Profile
        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'age' => $this->age,
                'gender' => $this->gender,
                'height_cm' => $this->height_cm,
                'current_weight_kg' => $this->current_weight_kg,
                'goal_weight_kg' => $this->goal_weight_kg,
                'target_date' => $this->target_date,
                'activity_level' => $this->activity_level,
                'cooking_skill_level' => $this->cooking_skill_level,
                'food_budget_level' => $this->food_budget_level,
                'daily_schedule' => $this->daily_schedule,
                'water_intake_liters' => $this->water_intake_liters,
                'sleep_hours' => $this->sleep_hours,
                'stress_level' => $this->stress_level,
                'onboarding_completed_at' => now(),
            ]
        );
        
        // Create/Update Health Profile
        HealthProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'dietary_preference' => $this->dietary_preference,
                'allergies' => $this->allergies ? json_encode(explode(',', $this->allergies)) : null,
                'foods_to_avoid' => $this->foods_to_avoid ? json_encode(explode(',', $this->foods_to_avoid)) : null,
                'medical_conditions' => $this->medical_conditions ? json_encode(explode(',', $this->medical_conditions)) : null,
            ]
        );
        
        // Create/Update Goal Profile
        GoalProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'goal_type' => $this->goal_type,
                'goal_pace' => $this->goal_pace,
            ]
        );
        
        session()->flash('success', 'Onboarding completed! Your personalized dashboard is ready.');
        $this->redirect(route('dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.onboarding-form');
    }
}
