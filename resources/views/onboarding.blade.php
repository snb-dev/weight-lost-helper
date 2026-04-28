<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-semibold text-white">Personalization Onboarding</h2>
            <p class="mt-1 text-sm text-slate-400">Collect the inputs needed for calorie targets, diet plans, and AI recipe tailoring.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <h3 class="text-lg font-semibold text-white">Profile blocks</h3>
                <ul class="mt-4 space-y-3 text-sm text-slate-300">
                    <li>Body metrics and target timeline</li>
                    <li>Dietary pattern, allergies, and restrictions</li>
                    <li>Schedule, cooking skill, budget, and pantry</li>
                    <li>Workout habits, water intake, sleep, and stress</li>
                </ul>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-6 lg:col-span-2">
                <h3 class="text-lg font-semibold text-white">Implementation note</h3>
                <p class="mt-3 max-w-3xl text-sm leading-7 text-slate-300">
                    The schema and services are in place for a full multi-step onboarding flow. The next implementation pass can turn this into
                    a Livewire wizard that persists profiles, health profiles, goal profiles, pantry items, and AI settings.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
