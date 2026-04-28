<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-white">Dashboard</h2>
                <p class="mt-1 text-sm text-slate-400">Your central view for calorie targets, recipe support, and momentum.</p>
            </div>
            <a href="{{ route('onboarding') }}" class="inline-flex items-center justify-center rounded-full border border-lime-300/30 bg-lime-300/10 px-4 py-2 text-sm font-semibold text-lime-200 transition hover:bg-lime-300/20">
                Complete personalization
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
            <section class="space-y-6">
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                        <p class="text-sm text-slate-400">Maintenance</p>
                        <p class="mt-3 text-3xl font-semibold text-white">{{ data_get($calories, 'maintenance', '--') }}</p>
                        <p class="mt-2 text-sm text-slate-300">Estimated daily calories to maintain current weight.</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                        <p class="text-sm text-slate-400">Fat-loss target</p>
                        <p class="mt-3 text-3xl font-semibold text-white">{{ data_get($calories, 'target', '--') }}</p>
                        <p class="mt-2 text-sm text-slate-300">Current recommended intake with safety guardrails.</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                        <p class="text-sm text-slate-400">Goal ETA</p>
                        <p class="mt-3 text-2xl font-semibold text-white">{{ data_get($prediction, 'estimated_goal_date')?->format('M j, Y') ?? 'Add profile data' }}</p>
                        <p class="mt-2 text-sm text-slate-300">Projection based on the current deficit model.</p>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-6">
                        <h3 class="text-lg font-semibold text-white">Macro guidance</h3>
                        <div class="mt-5 grid gap-4 sm:grid-cols-3">
                            <div class="rounded-2xl bg-slate-800/80 p-4">
                                <p class="text-sm text-slate-400">Protein</p>
                                <p class="mt-2 text-2xl font-semibold text-white">{{ data_get($macros, 'protein_g', '--') }}g</p>
                            </div>
                            <div class="rounded-2xl bg-slate-800/80 p-4">
                                <p class="text-sm text-slate-400">Carbs</p>
                                <p class="mt-2 text-2xl font-semibold text-white">{{ data_get($macros, 'carb_g', '--') }}g</p>
                            </div>
                            <div class="rounded-2xl bg-slate-800/80 p-4">
                                <p class="text-sm text-slate-400">Fat</p>
                                <p class="mt-2 text-2xl font-semibold text-white">{{ data_get($macros, 'fat_g', '--') }}g</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-6">
                        <h3 class="text-lg font-semibold text-white">Personalization status</h3>
                        <div class="mt-5 space-y-4 text-sm text-slate-300">
                            <div class="flex items-center justify-between rounded-2xl bg-slate-800/80 px-4 py-3">
                                <span>Profile</span>
                                <span>{{ $user->profile ? 'Ready' : 'Pending' }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-800/80 px-4 py-3">
                                <span>Health restrictions</span>
                                <span>{{ $user->healthProfile ? 'Ready' : 'Pending' }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-800/80 px-4 py-3">
                                <span>Goal settings</span>
                                <span>{{ $user->goalProfile ? 'Ready' : 'Pending' }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-800/80 px-4 py-3">
                                <span>AI provider settings</span>
                                <span>{{ $user->aiSetting ? 'Ready' : 'Placeholder mode' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <aside class="space-y-6">
                <div class="rounded-[2rem] border border-white/10 bg-gradient-to-br from-sky-500/20 to-lime-300/20 p-6">
                    <p class="text-sm uppercase tracking-[0.25em] text-slate-200">Recipe Studio</p>
                    <h3 class="mt-3 text-2xl font-semibold text-white">AI meal generation is ready for OpenRouter integration.</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-100/90">
                        The service layer now builds model payloads from user goals, restrictions, preferred cuisines, and macro targets.
                    </p>
                    <a href="{{ route('recipes.studio') }}" class="mt-6 inline-flex items-center rounded-full bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-100">
                        Open recipe studio
                    </a>
                </div>

                <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6">
                    <h3 class="text-lg font-semibold text-white">What’s in this build</h3>
                    <ul class="mt-4 space-y-3 text-sm text-slate-300">
                        <li>Comprehensive health and planning schema</li>
                        <li>Nutrition target services for dashboard estimates</li>
                        <li>Queue-ready AI recipe payload preparation</li>
                        <li>Product-shaped landing, dashboard, planner, and tracking screens</li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>
