<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-full border border-red-400/20 bg-red-500/90 px-4 py-2 font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 focus:ring-offset-slate-950 active:bg-red-600']) }}>
    {{ $slot }}
</button>
