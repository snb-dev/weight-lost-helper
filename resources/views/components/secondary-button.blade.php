<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center rounded-full border border-white/10 bg-white/5 px-4 py-2 font-semibold uppercase tracking-widest text-slate-100 shadow-sm transition duration-150 ease-in-out hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-lime-300 focus:ring-offset-2 focus:ring-offset-slate-950 disabled:opacity-25']) }}>
    {{ $slot }}
</button>
