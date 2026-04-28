@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-2xl border border-white/10 bg-slate-900/80 px-4 py-3 text-slate-100 placeholder:text-slate-500 shadow-sm focus:border-lime-300/60 focus:ring focus:ring-lime-300/20']) }}>
