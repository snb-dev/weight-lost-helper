<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Weight Loss Helper</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-950 text-slate-50 antialiased">
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(132,204,22,0.18),_transparent_30%),radial-gradient(circle_at_80%_10%,_rgba(14,165,233,0.18),_transparent_28%),linear-gradient(180deg,_#020617_0%,_#0f172a_50%,_#111827_100%)]"></div>

            <div class="relative mx-auto flex min-h-screen max-w-7xl flex-col px-6 py-8 lg:px-10">
                <header class="flex items-center justify-between gap-6">
                    <div class="flex items-center gap-3">
                        <x-application-logo class="h-11 w-auto text-lime-300" />
                        <div>
                            <p class="text-sm uppercase tracking-[0.35em] text-lime-300/80">Weight Loss Helper</p>
                            <p class="text-sm text-slate-400">Personalized planning, tracking, and AI-powered meal support</p>
                        </div>
                    </div>

                    @if (Route::has('login'))
                        <livewire:welcome.navigation />
                    @endif
                </header>

                <main class="grid flex-1 items-center gap-12 py-16 lg:grid-cols-[1.1fr_0.9fr]">
                    <section class="space-y-8">
                        <div class="inline-flex items-center gap-2 rounded-full border border-lime-300/20 bg-lime-300/10 px-4 py-2 text-sm text-lime-100">
                            Built for sustainable fat loss, meal planning, and daily momentum
                        </div>

                        <div class="space-y-6">
                            <h1 class="max-w-4xl text-5xl font-semibold leading-tight text-white sm:text-6xl">
                                A modern weight loss platform that turns goals into daily action.
                            </h1>
                            <p class="max-w-2xl text-lg leading-8 text-slate-300">
                                Track weight trends, generate calorie-aware meal plans, create AI recipes from your pantry,
                                and keep motivation high with milestones, habit streaks, and progress insights.
                            </p>
                        </div>

                        <div class="flex flex-col gap-4 sm:flex-row">
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full bg-lime-300 px-6 py-3 text-base font-semibold text-slate-950 transition hover:bg-lime-200">
                                Start your plan
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full border border-white/15 bg-white/5 px-6 py-3 text-base font-semibold text-white transition hover:border-lime-300/40 hover:bg-white/10">
                                Sign in
                            </a>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-3">
                            <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                                <p class="text-sm text-slate-400">Profile depth</p>
                                <p class="mt-2 text-2xl font-semibold text-white">30+</p>
                                <p class="mt-2 text-sm text-slate-300">Signals across health, preferences, habits, budget, and schedule.</p>
                            </div>
                            <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                                <p class="text-sm text-slate-400">AI recipe support</p>
                                <p class="mt-2 text-2xl font-semibold text-white">Queued</p>
                                <p class="mt-2 text-sm text-slate-300">OpenRouter-ready generation flow with user-supplied API keys later.</p>
                            </div>
                            <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                                <p class="text-sm text-slate-400">Decision support</p>
                                <p class="mt-2 text-2xl font-semibold text-white">Adaptive</p>
                                <p class="mt-2 text-sm text-slate-300">Macros, calorie targets, grocery lists, and progress projections.</p>
                            </div>
                        </div>
                    </section>

                    <section class="grid gap-5">
                        <div class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-6 shadow-2xl shadow-black/20">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-sm text-slate-400">Today’s focus</p>
                                    <h2 class="mt-1 text-2xl font-semibold text-white">Stay on plan without overthinking meals</h2>
                                </div>
                                <div class="rounded-full bg-lime-300/15 px-4 py-2 text-sm text-lime-200">Sustainable mode</div>
                            </div>

                            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                <div class="rounded-2xl bg-slate-800/70 p-5">
                                    <p class="text-sm text-slate-400">Target calories</p>
                                    <p class="mt-2 text-4xl font-semibold text-white">1,850</p>
                                    <p class="mt-2 text-sm text-slate-300">Balanced for fat loss with protein protection.</p>
                                </div>
                                <div class="rounded-2xl bg-slate-800/70 p-5">
                                    <p class="text-sm text-slate-400">Water goal</p>
                                    <p class="mt-2 text-4xl font-semibold text-white">2.5L</p>
                                    <p class="mt-2 text-sm text-slate-300">Reminder-ready hydration tracking.</p>
                                </div>
                            </div>

                            <div class="mt-5 rounded-2xl border border-white/10 bg-gradient-to-r from-sky-500/15 to-lime-300/15 p-5">
                                <p class="text-sm text-slate-300">Recipe prompt example</p>
                                <p class="mt-3 text-base leading-7 text-white">
                                    "Create a high-protein Sri Lankan chicken bowl under 550 calories using rice, yogurt, cucumber,
                                    and low-cost ingredients. Avoid peanuts and suggest a vegetarian alternative."
                                </p>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                                <p class="text-sm text-slate-400">Core modules</p>
                                <ul class="mt-3 space-y-2 text-sm text-slate-200">
                                    <li>Weight, BMI, and measurement trends</li>
                                    <li>Diet plans and grocery generation</li>
                                    <li>AI recipe alternatives and bookmarks</li>
                                    <li>Water, habits, milestones, and reports</li>
                                </ul>
                            </div>
                            <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                                <p class="text-sm text-slate-400">Architecture</p>
                                <ul class="mt-3 space-y-2 text-sm text-slate-200">
                                    <li>Laravel + Breeze + Livewire foundation</li>
                                    <li>Queue-ready AI workflow for OpenRouter</li>
                                    <li>PostgreSQL-ready schema with SQLite dev mode</li>
                                    <li>Clean domain services for nutrition logic</li>
                                </ul>
                            </div>
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </body>
</html>
