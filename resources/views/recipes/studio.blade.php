<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-semibold text-white">AI Recipe Studio</h2>
            <p class="mt-1 text-sm text-slate-400">OpenRouter-ready recipe generation designed for goals, restrictions, pantry items, and budget.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-[1.3fr_0.7fr]">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <h3 class="text-lg font-semibold text-white">Generation contract</h3>
                <p class="mt-3 text-sm leading-7 text-slate-300">
                    The service layer now prepares OpenRouter payloads using user profile data, nutrition targets, and recipe constraints.
                    The next pass can connect this to a queued job, JSON validation, and alternative generation actions.
                </p>

                <div class="mt-6 rounded-2xl bg-slate-900/70 p-5 text-sm text-slate-200">
                    <p class="font-semibold text-white">Output shape</p>
                    <p class="mt-3">Ingredients, steps, nutrition facts, calories/macros, tags, substitutions, and model traceability.</p>
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <h3 class="text-lg font-semibold text-white">Recommended free-model posture</h3>
                <ul class="mt-4 space-y-3 text-sm text-slate-300">
                    @foreach (config('openrouter.recommended_free_models') as $model)
                        <li>{{ $model }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
