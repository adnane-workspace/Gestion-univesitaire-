@props(['title', 'value', 'icon', 'color' => 'indigo', 'trend' => null])

@php
    $colors = [
        'indigo' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'icon_bg' => 'bg-indigo-600'],
        'emerald' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'icon_bg' => 'bg-emerald-600'],
        'rose' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-600', 'icon_bg' => 'bg-rose-600'],
        'amber' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'icon_bg' => 'bg-amber-600'],
        'sky' => ['bg' => 'bg-sky-50', 'text' => 'text-sky-600', 'icon_bg' => 'bg-sky-600'],
    ];
    $c = $colors[$color] ?? $colors['indigo'];
@endphp

<div class="bg-white p-8 rounded-[2rem] border border-slate-200/60 shadow-sm hover:shadow-md transition-all group">
    <div class="flex items-start justify-between mb-6">
        <div class="w-14 h-14 rounded-2xl {{ $c['bg'] }} {{ $c['text'] }} flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
            {!! $icon !!}
        </div>
        @if($trend)
            <span class="flex items-center gap-1 text-xs font-bold px-3 py-1 rounded-full {{ $trend > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $trend > 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}" />
                </svg>
                {{ abs($trend) }}%
            </span>
        @endif
    </div>
    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-1">{{ $title }}</p>
    <p class="text-3xl font-black text-[#1E293B]">{{ $value }}</p>
</div>
