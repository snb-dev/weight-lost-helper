<div class="min-h-screen bg-gray-50">
    <livewire:components.navbar />

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Meal Tracking</h1>
            <p class="text-gray-600 mt-2">Track your meals and monitor nutritional intake</p>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <p class="text-green-800">✓ {{ session('success') }}</p>
            </div>
        @endif

        <!-- Date Picker -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                <label class="font-medium text-gray-700">Select Date:</label>
                <input 
                    wire:model.live="logged_on" 
                    type="date"
                    max="{{ now()->toDateString() }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
            </div>
        </div>

        <!-- Today's Nutrition Summary -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                <div class="text-sm text-blue-600 font-medium">Total Calories</div>
                <div class="text-2xl font-bold text-blue-900 mt-1">{{ $stats['totalCalories'] }}</div>
                <div class="text-xs text-blue-600 mt-2">kcal</div>
            </div>
            <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                <div class="text-sm text-purple-600 font-medium">Protein</div>
                <div class="text-2xl font-bold text-purple-900 mt-1">{{ $stats['totalProtein'] }}</div>
                <div class="text-xs text-purple-600 mt-2">g</div>
            </div>
            <div class="bg-amber-50 rounded-lg p-4 border border-amber-200">
                <div class="text-sm text-amber-600 font-medium">Carbs</div>
                <div class="text-2xl font-bold text-amber-900 mt-1">{{ $stats['totalCarbs'] }}</div>
                <div class="text-xs text-amber-600 mt-2">g</div>
            </div>
            <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                <div class="text-sm text-red-600 font-medium">Fat</div>
                <div class="text-2xl font-bold text-red-900 mt-1">{{ $stats['totalFat'] }}</div>
                <div class="text-xs text-red-600 mt-2">g</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 sticky top-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        {{ $editingId ? 'Edit Meal' : 'Log Meal' }}
                    </h2>

                    <form wire:submit="submit" class="space-y-4">
                        <!-- Meal Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Meal Type *</label>
                            <select 
                                wire:model="meal_type"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">Select meal type</option>
                                <option value="breakfast">🌅 Breakfast</option>
                                <option value="snack">🥤 Snack</option>
                                <option value="lunch">🍽️ Lunch</option>
                                <option value="dinner">🌙 Dinner</option>
                            </select>
                            @error('meal_type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Meal Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Meal Name *</label>
                            <input 
                                wire:model="meal_name" 
                                type="text"
                                placeholder="e.g., Grilled Chicken with Rice"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                            @error('meal_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                            <input 
                                wire:model="logged_on" 
                                type="date"
                                max="{{ now()->toDateString() }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                            @error('logged_on') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Calories -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Calories (kcal)</label>
                            <input 
                                wire:model="calories" 
                                type="number"
                                step="1"
                                min="0"
                                max="3000"
                                placeholder="Optional"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                            @error('calories') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Macros Grid -->
                        <div class="grid grid-cols-3 gap-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Protein (g)</label>
                                <input 
                                    wire:model="protein_g" 
                                    type="number"
                                    step="0.1"
                                    min="0"
                                    max="300"
                                    placeholder="0"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Carbs (g)</label>
                                <input 
                                    wire:model="carbs_g" 
                                    type="number"
                                    step="0.1"
                                    min="0"
                                    max="300"
                                    placeholder="0"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Fat (g)</label>
                                <input 
                                    wire:model="fat_g" 
                                    type="number"
                                    step="0.1"
                                    min="0"
                                    max="300"
                                    placeholder="0"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                />
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <textarea 
                                wire:model="notes"
                                rows="2"
                                placeholder="Any details about this meal..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            ></textarea>
                            @error('notes') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-2">
                            <button 
                                type="submit"
                                class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium"
                                wire:loading.attr="disabled"
                            >
                                <span wire:loading.remove>{{ $editingId ? 'Update Meal' : 'Log Meal' }}</span>
                                <span wire:loading>Saving...</span>
                            </button>

                            @if ($editingId)
                                <button 
                                    type="button"
                                    wire:click="resetForm"
                                    class="flex-1 px-4 py-2 bg-gray-300 text-gray-900 rounded-lg hover:bg-gray-400 transition font-medium"
                                >
                                    Cancel
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Meals List Section -->
            <div class="lg:col-span-2">
                <div class="space-y-3">
                    @forelse ($meals as $meal)
                        <div class="bg-white rounded-lg shadow p-4 hover:shadow-md transition">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-lg">
                                            @switch($meal->meal_type)
                                                @case('breakfast')
                                                    🌅
                                                    @break
                                                @case('snack')
                                                    🥤
                                                    @break
                                                @case('lunch')
                                                    🍽️
                                                    @break
                                                @case('dinner')
                                                    🌙
                                                    @break
                                            @endswitch
                                        </span>
                                        <h3 class="font-semibold text-gray-900">{{ $meal->meal_name }}</h3>
                                        <span class="text-xs px-2 py-1 bg-gray-200 text-gray-700 rounded capitalize">
                                            {{ ucfirst($meal->meal_type) }}
                                        </span>
                                    </div>

                                    @if ($meal->notes)
                                        <p class="text-sm text-gray-600 mb-2">{{ $meal->notes }}</p>
                                    @endif

                                    <!-- Nutrition Info -->
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-sm">
                                        @if ($meal->calories)
                                            <div class="bg-blue-50 px-2 py-1 rounded">
                                                <span class="text-gray-600">Calories:</span>
                                                <span class="font-medium text-blue-900">{{ $meal->calories }} kcal</span>
                                            </div>
                                        @endif
                                        @if ($meal->protein_g)
                                            <div class="bg-purple-50 px-2 py-1 rounded">
                                                <span class="text-gray-600">Protein:</span>
                                                <span class="font-medium text-purple-900">{{ $meal->protein_g }}g</span>
                                            </div>
                                        @endif
                                        @if ($meal->carbs_g)
                                            <div class="bg-amber-50 px-2 py-1 rounded">
                                                <span class="text-gray-600">Carbs:</span>
                                                <span class="font-medium text-amber-900">{{ $meal->carbs_g }}g</span>
                                            </div>
                                        @endif
                                        @if ($meal->fat_g)
                                            <div class="bg-red-50 px-2 py-1 rounded">
                                                <span class="text-gray-600">Fat:</span>
                                                <span class="font-medium text-red-900">{{ $meal->fat_g }}g</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex gap-2 w-full sm:w-auto">
                                    <button 
                                        wire:click="edit({{ $meal->id }})"
                                        class="flex-1 sm:flex-none px-3 py-1 text-sm text-blue-600 hover:text-blue-700 font-medium hover:bg-blue-50 rounded transition"
                                    >
                                        Edit
                                    </button>
                                    <button 
                                        wire:click="delete({{ $meal->id }})"
                                        onclick="return confirm('Delete this meal?')"
                                        class="flex-1 sm:flex-none px-3 py-1 text-sm text-red-600 hover:text-red-700 font-medium hover:bg-red-50 rounded transition"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow p-8 text-center">
                            <div class="text-4xl mb-3">🍽️</div>
                            <p class="text-gray-600">No meals logged for this date. Start by logging your first meal above!</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if ($meals->hasPages())
                    <div class="mt-6">
                        {{ $meals->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
