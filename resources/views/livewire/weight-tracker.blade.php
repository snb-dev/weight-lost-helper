<div class="min-h-screen bg-gray-50">
    <livewire:components.navbar />

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Weight Tracking</h1>
            <p class="text-gray-600 mt-2">Log and monitor your weight progress</p>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <p class="text-green-800">✓ {{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        {{ $editingId ? 'Edit Weight Log' : 'Log Weight' }}
                    </h2>

                    <form wire:submit="submit" class="space-y-4">
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

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Weight (kg)</label>
                            <input 
                                wire:model="weight_kg" 
                                type="number" 
                                step="0.1"
                                min="30"
                                max="500"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                            @error('weight_kg') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <textarea 
                                wire:model="notes"
                                rows="3"
                                placeholder="How are you feeling? Any comments?"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            ></textarea>
                        </div>

                        <div class="flex gap-2">
                            <button 
                                type="submit"
                                class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium"
                                wire:loading.attr="disabled"
                            >
                                <span wire:loading.remove>{{ $editingId ? 'Update' : 'Log Weight' }}</span>
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

                    <!-- Weekly Stats -->
                    @if (count($stats['thisWeek']) > 0)
                        <div class="mt-6 pt-6 border-t">
                            <h3 class="font-semibold text-gray-900 mb-3">This Week</h3>
                            @php
                                $weekWeights = $stats['thisWeek']->pluck('weight_kg');
                                $minWeight = $weekWeights->min();
                                $maxWeight = $weekWeights->max();
                                $avgWeight = round($weekWeights->avg(), 1);
                            @endphp
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Highest:</span>
                                    <span class="font-medium">{{ $maxWeight }} kg</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Lowest:</span>
                                    <span class="font-medium">{{ $minWeight }} kg</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Average:</span>
                                    <span class="font-medium">{{ $avgWeight }} kg</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Entries:</span>
                                    <span class="font-medium">{{ count($stats['thisWeek']) }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- History Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Weight History</h2>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3 px-4 font-medium text-gray-700">Date</th>
                                    <th class="text-left py-3 px-4 font-medium text-gray-700">Weight</th>
                                    <th class="text-left py-3 px-4 font-medium text-gray-700">BMI</th>
                                    <th class="text-left py-3 px-4 font-medium text-gray-700">Notes</th>
                                    <th class="text-left py-3 px-4 font-medium text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($logs as $log)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 px-4 text-gray-900">
                                            {{ \Carbon\Carbon::parse($log->logged_on)->format('M d, Y') }}
                                        </td>
                                        <td class="py-3 px-4">
                                            <span class="font-semibold text-gray-900">{{ $log->weight_kg }} kg</span>
                                        </td>
                                        <td class="py-3 px-4 text-gray-600">
                                            {{ $log->bmi ? round($log->bmi, 1) : '—' }}
                                        </td>
                                        <td class="py-3 px-4 text-gray-600 max-w-xs truncate">
                                            {{ $log->notes ?? '—' }}
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex gap-2">
                                                <button 
                                                    wire:click="edit({{ $log->id }})"
                                                    class="text-blue-600 hover:text-blue-700 font-medium"
                                                >
                                                    Edit
                                                </button>
                                                <button 
                                                    wire:click="delete({{ $log->id }})"
                                                    onclick="return confirm('Delete this log?')"
                                                    class="text-red-600 hover:text-red-700 font-medium"
                                                >
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 px-4 text-center text-gray-600">
                                            No weight logs yet. Start tracking by logging your weight above.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($logs->hasPages())
                        <div class="mt-4">
                            {{ $logs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
