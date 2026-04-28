<?php

namespace App\Livewire;

use App\Models\WeightLog;
use App\Models\Profile;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class WeightTracker extends Component
{
    use WithPagination;

    #[Validate('required|date|before_or_equal:today')]
    public $logged_on = '';

    #[Validate('required|numeric|min:30|max:500')]
    public $weight_kg = '';

    public $notes = '';
    public $showForm = false;
    public $editingId = null;

    public function mount()
    {
        $this->logged_on = now()->toDateString();
    }

    public function submit()
    {
        $this->validate();

        if ($this->editingId) {
            $log = WeightLog::findOrFail($this->editingId);
            $log->update([
                'weight_kg' => $this->weight_kg,
                'logged_on' => $this->logged_on,
                'notes' => $this->notes,
            ]);
            
            $this->calculateBMI($log);
            session()->flash('success', 'Weight log updated successfully!');
        } else {
            $log = WeightLog::create([
                'user_id' => auth()->id(),
                'weight_kg' => $this->weight_kg,
                'logged_on' => $this->logged_on,
                'notes' => $this->notes,
            ]);
            
            $this->calculateBMI($log);
            session()->flash('success', 'Weight logged successfully!');
        }

        $this->resetForm();
    }

    public function calculateBMI($log)
    {
        $profile = auth()->user()->profile;
        if ($profile) {
            $heightCm = $profile->height_cm;
            $bmi = $log->weight_kg / (($heightCm / 100) ** 2);
            $log->update(['bmi' => round($bmi, 2)]);
        }
    }

    public function edit($id)
    {
        $log = WeightLog::findOrFail($id);
        $this->editingId = $id;
        $this->logged_on = $log->logged_on;
        $this->weight_kg = $log->weight_kg;
        $this->notes = $log->notes;
        $this->showForm = true;
    }

    public function delete($id)
    {
        WeightLog::findOrFail($id)->delete();
        session()->flash('success', 'Weight log deleted successfully!');
    }

    public function resetForm()
    {
        $this->reset(['weight_kg', 'notes', 'showForm', 'editingId']);
        $this->logged_on = now()->toDateString();
    }

    public function render()
    {
        $logs = WeightLog::where('user_id', auth()->id())
            ->orderBy('logged_on', 'desc')
            ->paginate(10);

        $stats = [
            'thisWeek' => WeightLog::where('user_id', auth()->id())
                ->whereBetween('logged_on', [now()->startOfWeek(), now()->endOfWeek()])
                ->get(),
            'thisMonth' => WeightLog::where('user_id', auth()->id())
                ->whereBetween('logged_on', [now()->startOfMonth(), now()->endOfMonth()])
                ->get(),
        ];

        return view('livewire.weight-tracker', [
            'logs' => $logs,
            'stats' => $stats,
        ]);
    }
}
