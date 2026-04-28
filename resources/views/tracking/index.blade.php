<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-semibold text-white">Tracking Hub</h2>
            <p class="mt-1 text-sm text-slate-400">Weight logs, measurement trends, calories, hydration, and milestones in one place.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['Weight logs', 'Daily or weekly weigh-ins with BMI trend support.'],
                ['Measurements', 'Waist, chest, hips, thigh, and arm tracking.'],
                ['Hydration', 'Water intake reminders and completion logs.'],
                ['Milestones', 'Celebrate consistency, streaks, and visible progress.'],
            ] as [$title, $description])
                <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                    <h3 class="text-lg font-semibold text-white">{{ $title }}</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-300">{{ $description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
