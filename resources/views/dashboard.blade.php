<x-app-layout>
    {{-- No header slot: hero fills below navbar --}}

    @php
        $displayName = trim(implode(' ', array_filter([Auth::user()->name ?? '', Auth::user()->surname ?? '']))) ?: Auth::user()->name;
    @endphp

    {{-- Full-height hero: viewport minus nav (h-16 = 4rem) --}}
    <div class="relative w-full min-h-[calc(100vh-4rem)] flex items-center justify-center overflow-hidden">
        <img
            src="{{ asset('images/kafic.jpg') }}"
            alt=""
            class="absolute inset-0 w-full h-full object-cover object-center"
            onerror="this.classList.add('!hidden'); document.getElementById('hero-fallback').classList.remove('!hidden');"
        >
        <div id="hero-fallback" class="!hidden absolute inset-0 w-full h-full bg-gradient-to-br from-amber-100 to-orange-200" aria-hidden="true"></div>
        <div class="absolute inset-0 bg-black/40" aria-hidden="true"></div>

        <div class="relative z-10 text-center px-4">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white drop-shadow-lg tracking-tight">
                Zdravo, {{ $displayName }}!
            </h1>
        </div>
    </div>
</x-app-layout>
