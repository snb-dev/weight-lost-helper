<div class="min-h-screen bg-gray-50">
    <!-- Top Navigation -->
    <livewire:components.navbar />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}!</h1>
            <p class="text-gray-600 mt-2">Here's your progress overview</p>
        </div>

        @if (empty($stats))
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <p class="text-yellow-800">
                    📝 Complete your profile to see personalized metrics.
                    <a href="{{ route('profile.edit') }}" class="font-medium underline">Edit Profile</a>
                </p>
            </div>
        @else
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Current Weight -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Current Weight</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['currentWeight'] }} kg</p>
                            <p class="text-xs text-gray-500 mt-2">Goal: {{ $stats['goalWeight'] }} kg</p>
                        </div>
                        <div class="text-4xl">⚖️</div>
                    </div>
                </div>

                <!-- Weight Lost -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Weight Lost</p>
                            <p class="text-3xl font-bold text-green-600 mt-1">
                                {{ $stats['weightLost'] > 0 ? '+' : '' }}{{ $stats['weightLost'] }} kg
                            </p>
                            <p class="text-xs text-gray-500 mt-2">
                                {{ $stats['daysRemaining'] }} days remaining
                            </p>
                        </div>
                        <div class="text-4xl">📉</div>
                    </div>
                </div>

                <!-- BMI -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">BMI</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['bmi'] }}</p>
                            <p class="text-xs text-gray-500 mt-2">
                                @if ($stats['bmi'] < 18.5)
                                    Underweight
                                @elseif ($stats['bmi'] < 25)
                                    Normal
                                @elseif ($stats['bmi'] < 30)
                                    Overweight
                                @else
                                    Obese
                                @endif
                            </p>
                        </div>
                        <div class="text-4xl">📊</div>
                    </div>
                </div>

                <!-- Daily Calories -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Daily Target</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['dailyCalorieTarget'] }}</p>
                            <p class="text-xs text-gray-500 mt-2">Calories/day</p>
                        </div>
                        <div class="text-4xl">🔥</div>
                    </div>
                </div>
            </div>

            <!-- Today's Logs -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Today's Weight -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Today's Weight</h3>
                    @if ($todayLogs['weight'])
                        <p class="text-2xl font-bold text-gray-900">{{ $todayLogs['weight']->weight_kg }} kg</p>
                        <p class="text-sm text-gray-600 mt-2">
                            BMI: {{ round($todayLogs['weight']->bmi, 1) }}
                        </p>
                        @if ($todayLogs['weight']->notes)
                            <p class="text-sm text-gray-600 mt-2">{{ $todayLogs['weight']->notes }}</p>
                        @endif
                    @else
                        <p class="text-gray-600">No entry yet today</p>
                        <a href="{{ route('tracking.weight') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium mt-2 inline-block">
                            Log weight →
                        </a>
                    @endif
                </div>

                <!-- Today's Calories -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Today's Calories</h3>
                    @if ($todayLogs['calories'])
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $todayLogs['calories']->consumed_calories }} 
                            <span class="text-sm text-gray-600">/ {{ $stats['dailyCalorieTarget'] }}</span>
                        </p>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all" 
                                style="width: {{ min(100, ($todayLogs['calories']->consumed_calories / $stats['dailyCalorieTarget']) * 100) }}%">
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">
                            @php
                                $remaining = $stats['dailyCalorieTarget'] - $todayLogs['calories']->consumed_calories;
                            @endphp
                            {{ $remaining > 0 ? $remaining . ' remaining' : 'Over by ' . abs($remaining) }}
                        </p>
                    @else
                        <p class="text-gray-600">No entries yet today</p>
                        <a href="{{ route('tracking.meals') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium mt-2 inline-block">
                            Log meal →
                        </a>
                    @endif
                </div>

                <!-- Today's Water -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Water Intake</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $todayLogs['water'] }} L</p>
                    <p class="text-sm text-gray-600 mt-2">Target: 2.0 L</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-blue-400 h-2 rounded-full transition-all" 
                            style="width: {{ min(100, ($todayLogs['water'] / 2.0) * 100) }}%">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <a href="{{ route('tracking.weight') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition text-center">
                    <div class="text-3xl mb-2">⚖️</div>
                    <h4 class="font-semibold text-gray-900">Log Weight</h4>
                    <p class="text-xs text-gray-600 mt-1">Track daily progress</p>
                </a>

                <a href="{{ route('tracking.meals') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition text-center">
                    <div class="text-3xl mb-2">🍔</div>
                    <h4 class="font-semibold text-gray-900">Log Meal</h4>
                    <p class="text-xs text-gray-600 mt-1">Track calories</p>
                </a>

                <a href="{{ route('recipes.studio') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition text-center">
                    <div class="text-3xl mb-2">🤖</div>
                    <h4 class="font-semibold text-gray-900">AI Recipes</h4>
                    <p class="text-xs text-gray-600 mt-1">Generate personalized recipes</p>
                </a>

                <a href="{{ route('profile.edit') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition text-center">
                    <div class="text-3xl mb-2">⚙️</div>
                    <h4 class="font-semibold text-gray-900">Settings</h4>
                    <p class="text-xs text-gray-600 mt-1">Edit your profile</p>
                </a>
            </div>

            <!-- Recent Weight Logs -->
            @if (count($chartData['weights']) > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Weight Trend (Last 7 Days)</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2 px-4 font-medium text-gray-700">Date</th>
                                    <th class="text-left py-2 px-4 font-medium text-gray-700">Weight</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($chartData['days'] as $index => $day)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-2 px-4 text-gray-900">{{ $day }}</td>
                                        <td class="py-2 px-4 text-gray-900">{{ $chartData['weights'][$index] }} kg</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
