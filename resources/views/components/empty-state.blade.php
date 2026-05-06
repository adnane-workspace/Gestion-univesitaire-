@props(['title', 'description', 'icon' => 'folder-open'])

<div class="flex flex-col items-center justify-center py-20 px-6 text-center animate-fade-in">
    <div class="w-24 h-24 rounded-[2rem] bg-slate-50 text-slate-300 flex items-center justify-center mb-8 border border-slate-100 shadow-inner">
        @if($icon === 'folder-open')
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
            </svg>
        @elseif($icon === 'search')
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        @endif
    </div>
    <h3 class="text-xl font-black text-slate-800 mb-2">{{ $title }}</h3>
    <p class="text-slate-500 font-medium max-w-sm leading-relaxed">
        {{ $description }}
    </p>
</div>
