<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Weight Loss Helper</h1>
            <p class="text-gray-600 mt-2">Let's get you started on your journey</p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8 bg-white rounded-lg shadow p-4">
            <div class="flex justify-between mb-4">
                @foreach(['1' => 'Basic Info', '2' => 'Goals', '3' => 'Health', '4' => 'Lifestyle', '5' => 'Complete'] as $num => $label)
                    <div class="text-center flex-1">
                        <div class="flex justify-center mb-2">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold
                                {{ $num <= $this->step ? 'bg-blue-600' : 'bg-gray-300' }}">
                                {{ $num <= $this->step ? '✓' : $num }}
                            </div>
                        </div>
                        <span class="text-xs font-medium {{ $num <= $this->step ? 'text-blue-600' : 'text-gray-500' }}">{{ $label }}</span>
                    </div>
                @endforeach
            </div>
            <div class="w-full bg-gray-200 rounded-full h-1">
                <div class="bg-blue-600 h-1 rounded-full transition-all" style="width: {{ ($this->step / 5) * 100 }}%"></div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form wire:submit="submit">
                <!-- Step 1: Basic Info -->
                @if ($this->step === 1)
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Basic Information</h2>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Age</label>
                            <input 
                                wire:model="age" 
                                type="number" 
                                min="18" 
                                max="120"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                            @error('age') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                            <select 
                                wire:model="gender"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">Select gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('gender') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Height (cm)</label>
                            <input 
                                wire:model="height_cm" 
                                type="number" 
                                min="100" 
                                max="300"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                            @error('height_cm') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Weight (kg)</label>
                            <input 
                                wire:model="current_weight_kg" 
                                type="number" 
                                step="0.1"
                                min="30" 
                                max="500"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                            @error('current_weight_kg') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif

                <!-- Step 2: Goals -->
                @if ($this->step === 2)
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Weight Loss Goals</h2>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Goal Weight (kg)</label>
                        <input 
                            wire:model="goal_weight_kg" 
                            type="number" 
                            step="0.1"
                            min="30" 
                            max="300"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                        @error('goal_weight_kg') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Target Date</label>
                        <input 
                            wire:model="target_date" 
                            type="date"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                        @error('target_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Activity Level</label>
                        <select 
                            wire:model="activity_level"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            <option value="">Select activity level</option>
                            <option value="Sedentary">Sedentary (little to no exercise)</option>
                            <option value="Light">Light (1-3 days/week)</option>
                            <option value="Moderate">Moderate (4-5 days/week)</option>
                            <option value="VeryActive">Very Active (6-7 days/week)</option>
                        </select>
                        @error('activity_level') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                @endif

                <!-- Step 3: Health -->
                @if ($this->step === 3)
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Health & Dietary</h2>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dietary Preference</label>
                        <select 
                            wire:model="dietary_preference"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            <option value="">Select preference</option>
                            <option value="omnivore">Omnivore</option>
                            <option value="vegetarian">Vegetarian</option>
                            <option value="vegan">Vegan</option>
                            <option value="keto">Keto</option>
                            <option value="low-carb">Low Carb</option>
                            <option value="paleo">Paleo</option>
                        </select>
                        @error('dietary_preference') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Allergies (comma-separated)</label>
                        <input 
                            wire:model="allergies" 
                            type="text"
                            placeholder="e.g., nuts, shellfish, dairy"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foods to Avoid (comma-separated)</label>
                        <input 
                            wire:model="foods_to_avoid" 
                            type="text"
                            placeholder="e.g., pork, beef"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Medical Conditions (comma-separated)</label>
                        <input 
                            wire:model="medical_conditions" 
                            type="text"
                            placeholder="e.g., diabetes, hypertension"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                    </div>
                @endif

                <!-- Step 4: Lifestyle -->
                @if ($this->step === 4)
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Lifestyle</h2>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cooking Skill Level</label>
                            <select 
                                wire:model="cooking_skill_level"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">Select level</option>
                                <option value="Beginner">Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                            </select>
                            @error('cooking_skill_level') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Food Budget Level</label>
                            <select 
                                wire:model="food_budget_level"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">Select level</option>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                            @error('food_budget_level') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Sleep hours/night: <span class="font-bold text-blue-600">{{ number_format($sleep_hours, 1) }}</span>
                            </label>
                            <input 
                                wire:model="sleep_hours" 
                                type="range"
                                min="4"
                                max="12"
                                step="0.5"
                                class="w-full"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Water intake (liters): <span class="font-bold text-blue-600">{{ number_format($water_intake_liters, 1) }}</span>
                            </label>
                            <input 
                                wire:model="water_intake_liters" 
                                type="range"
                                min="1"
                                max="8"
                                step="0.5"
                                class="w-full"
                            />
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Stress Level (1-10): <span class="font-bold text-blue-600">{{ $stress_level }}</span>
                        </label>
                        <input 
                            wire:model="stress_level" 
                            type="range"
                            min="1"
                            max="10"
                            class="w-full"
                        />
                    </div>
                @endif

                <!-- Step 5: Confirmation -->
                @if ($this->step === 5)
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Review Your Information</h2>
                    
                    <div class="bg-blue-50 rounded-lg p-4 mb-6">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-700">Age:</span>
                                <p class="text-gray-900">{{ $age }} years</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Gender:</span>
                                <p class="text-gray-900">{{ $gender }}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Height:</span>
                                <p class="text-gray-900">{{ $height_cm }} cm</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Current Weight:</span>
                                <p class="text-gray-900">{{ $current_weight_kg }} kg</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Goal Weight:</span>
                                <p class="text-gray-900">{{ $goal_weight_kg }} kg</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Target Date:</span>
                                <p class="text-gray-900">{{ \Carbon\Carbon::parse($target_date)->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Activity Level:</span>
                                <p class="text-gray-900">{{ $activity_level }}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Dietary Preference:</span>
                                <p class="text-gray-900">{{ $dietary_preference }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <p class="text-green-800">
                            ✓ All information looks good! Your personalized nutrition targets and dashboard will be ready once you complete.
                        </p>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex justify-between mt-8">
                    @if ($this->step > 1)
                        <button 
                            type="button"
                            wire:click="previousStep"
                            class="px-6 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium"
                        >
                            ← Previous
                        </button>
                    @else
                        <div></div>
                    @endif

                    @if ($this->step < 5)
                        <button 
                            type="button"
                            wire:click="nextStep"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium"
                            wire:loading.attr="disabled"
                        >
                            Next →
                        </button>
                    @else
                        <button 
                            type="submit"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove>Complete Onboarding</span>
                            <span wire:loading>Completing...</span>
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
