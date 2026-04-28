<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-full border border-transparent bg-lime-300 px-4 py-2 font-semibold uppercase tracking-widest text-slate-950 transition duration-150 ease-in-out hover:bg-lime-200 focus:outline-none focus:ring-2 focus:ring-lime-300 focus:ring-offset-2 focus:ring-offset-slate-950 active:bg-lime-100']) }}>
    {{ $slot }}
</button>
