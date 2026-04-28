<nav class="-mx-3 flex flex-1 justify-end">
    @auth
        <a
            href="{{ url('/dashboard') }}"
            class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-white transition hover:border-lime-300/30 hover:bg-white/10 focus:outline-none"
        >
            Dashboard
        </a>
    @else
        <a
            href="{{ route('login') }}"
            class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-white transition hover:border-lime-300/30 hover:bg-white/10 focus:outline-none"
        >
            Log in
        </a>

        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="rounded-full bg-lime-300 px-4 py-2 font-medium text-slate-950 transition hover:bg-lime-200 focus:outline-none"
            >
                Register
            </a>
        @endif
    @endauth
</nav>
