<?php

namespace App\Livewire;

use App\Models\WeightLog;
use App\Models\CalorieLog;
use App\Models\WaterLog;
use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $stats = [];
    public $chartData = [];
    public $todayLogs = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadChartData();
        $this->loadTodayLogs();
    }

    public function loadStats()
    {
        $user = auth()->user()->loadMissing(['profile', 'goalProfile']);
        
        if (!$user->profile) {
            $this->stats = [];
            return;
        }

        $currentWeight = $user->profile->current_weight_kg;
        $goalWeight = $user->profile->goal_weight_kg;
        $heightCm = $user->profile->height_cm;
        $bmi = $currentWeight / (($heightCm / 100) ** 2);
        $weightLost = $currentWeight - $goalWeight;
        
        $targetDate = $user->profile->target_date ? Carbon::parse($user->profile->target_date) : null;
        $daysRemaining = $targetDate ? now()->diffInDays($targetDate, false) : 0;

        $this->stats = [
            'currentWeight' => round($currentWeight, 1),
            'goalWeight' => round($goalWeight, 1),
            'bmi' => round($bmi, 1),
            'weightLost' => round($weightLost, 1),
            'daysRemaining' => max(0, $daysRemaining),
            'dailyCalorieTarget' => $user->goalProfile->daily_calorie_target ?? 2000,
        ];
    }

    public function loadChartData()
    {
        $user = auth()->user();
        $last7Days = WeightLog::where('user_id', $user->id)
            ->orderBy('logged_on')
            ->where('logged_on', '>=', now()->subDays(7)->toDateString())
            ->get();

        $days = [];
        $weights = [];
        
        foreach ($last7Days as $log) {
            $days[] = Carbon::parse($log->logged_on)->format('M d');
            $weights[] = $log->weight_kg;
        }

        $this->chartData = [
            'days' => $days,
            'weights' => $weights,
        ];
    }

    public function loadTodayLogs()
    {
        $user = auth()->user();
        $today = now()->toDateString();

        $weightLog = WeightLog::where('user_id', $user->id)
            ->where('logged_on', $today)
            ->first();

        $calorieLog = CalorieLog::where('user_id', $user->id)
            ->where('logged_on', $today)
            ->first();

        $waterLog = WaterLog::where('user_id', $user->id)
            ->where('logged_on', $today)
            ->sum('liters');

        $this->todayLogs = [
            'weight' => $weightLog,
            'calories' => $calorieLog,
            'water' => $waterLog,
        ];
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
