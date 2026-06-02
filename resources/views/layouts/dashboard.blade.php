<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | EduPortal UPF</title>
    <meta name="description" content="Plateforme de gestion académique de l'Université Panafricaine.">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>
        /* Compact sidebar + label reveal on lg */
        #sidebar { width: 5rem; } /* 80px compact */
        @media (min-width: 1024px) { #sidebar { width: 260px; } }

        /* Sidebar link collapsed - hide text and keep icon centered */
        .sidebar-link { display: flex; align-items:center; gap:0.75rem; padding:0.625rem; border-radius:0.75rem; }
        /* hide text nodes on small screens by setting font-size:0, restore on lg */
        #sidebar .sidebar-link { font-size: 0; }
        #sidebar .sidebar-link svg, #sidebar .sidebar-link .icon { font-size: inherit; }
        @media (min-width:1024px) { #sidebar .sidebar-link { font-size: 0.875rem; } }

        /* Active left accent */
        .sidebar-link.active { position: relative; }
        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0.35rem;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 48%;
            border-radius: 9999px;
            background: linear-gradient(180deg,#6366F1,#3B82F6);
            box-shadow: 0 6px 18px rgba(59,130,246,0.12);
        }

        /* Set Inter as default */
        body { font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }

        /* Radial progress util (simple) */
        .radial-progress { --size: 7rem; width: var(--size); height: var(--size); border-radius: 9999px; display:grid; place-items:center; position:relative; }
        .radial-progress .track { position:absolute; inset:0; border-radius:9999px; background: conic-gradient(var(--color, #6366F1) var(--value, 0%), #E6E9F8 0%); }
        .radial-progress .inner { position:relative; width:84%; height:84%; border-radius:9999px; background:white; display:grid; place-items:center; font-weight:700; }
    </style>
</head>

<body class="h-full bg-background">

    {{-- Mobile sidebar overlay --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden lg:hidden" onclick="closeSidebar()"></div>

    <div class="flex h-full overflow-hidden">

        {{-- ═══════════════════════════════════════ SIDEBAR ═══════════════════════════════════════ --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 bg-white border-r border-border flex flex-col transform -translate-x-full lg:translate-x-0 lg:static lg:z-auto transition-transform duration-300 ease-out">

            {{-- Logo --}}
            <div class="px-4 py-4 flex items-center gap-3 border-b border-border-light shrink-0 justify-center lg:justify-start">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center shadow-md shadow-primary/20 shrink-0">
                    <span class="text-white font-black text-sm">U</span>
                </div>
                <div class="min-w-0 hidden lg:block">
                    <p class="text-sm font-black text-text leading-none tracking-tight">EduPortal</p>
                    <p class="text-[10px] font-bold text-text-muted uppercase tracking-widest mt-0.5">UPF</p>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
                <p class="px-3 mb-3 text-[10px] font-black uppercase tracking-[0.15em] text-text-muted">Navigation</p>
                @yield('sidebar-links')
            </nav>

            {{-- Logout --}}
            <div class="px-3 py-4 border-t border-border-light shrink-0">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-link flex items-center gap-3 px-3 py-2.5 w-full rounded-xl text-text-muted hover:bg-rose-50 hover:text-rose-600 transition-all font-bold text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        {{-- ═══════════════════════════════════════ MAIN ═══════════════════════════════════════ --}}
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">

            {{-- Header --}}
            <header class="bg-white/80 backdrop-blur-lg border-b border-border h-14 flex items-center justify-between px-4 lg:px-8 shrink-0 sticky top-0 z-30">
                <div class="flex items-center gap-3">
                    {{-- Mobile menu button --}}
                    <button onclick="openSidebar()" class="lg:hidden p-1.5 -ml-1.5 rounded-lg text-text-secondary hover:bg-slate-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-base font-black text-text tracking-tight">@yield('title')</h1>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col items-end">
                        <p class="text-xs font-bold text-text leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-[9px] font-black text-primary uppercase tracking-[0.15em] mt-0.5">{{ Auth::user()->role }}</p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-bold text-xs shadow-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            {{-- Scrollable Content --}}
            <div class="flex-1 overflow-y-auto">
                <div class="p-4 lg:p-6 xl:p-8 max-w-[1400px] mx-auto">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    {{-- Chatbot widget (student only) --}}
    @if(Auth::check() && Auth::user()->role === 'etudiant')
        <div class="fixed bottom-5 right-5 z-50 flex flex-col items-end gap-3" id="chatbot-floating-container">
            <div id="chatbot-box" class="hidden w-[440px] max-w-[calc(100vw-2.5rem)] bg-white rounded-2xl border border-border shadow-2xl shadow-slate-200/50 overflow-hidden transition-all duration-300 transform scale-95 opacity-0 origin-bottom-right">
                <div id="app"></div>
            </div>

            <button id="chatbot-toggle-btn" class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary to-primary-dark text-white flex items-center justify-center shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 transition-all hover:scale-105 active:scale-95 cursor-pointer relative">
                <span class="absolute -top-0.5 -right-0.5 flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500 border-2 border-white"></span>
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" id="chatbot-icon-open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" id="chatbot-icon-close" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toggleBtn = document.getElementById('chatbot-toggle-btn');
                const chatBox = document.getElementById('chatbot-box');
                const iconOpen = document.getElementById('chatbot-icon-open');
                const iconClose = document.getElementById('chatbot-icon-close');

                toggleBtn.addEventListener('click', function() {
                    const isOpen = !chatBox.classList.contains('hidden');
                    if (isOpen) {
                        chatBox.classList.remove('scale-100', 'opacity-100');
                        chatBox.classList.add('scale-95', 'opacity-0');
                        setTimeout(() => chatBox.classList.add('hidden'), 250);
                        iconOpen.classList.remove('hidden');
                        iconClose.classList.add('hidden');
                    } else {
                        chatBox.classList.remove('hidden');
                        requestAnimationFrame(() => {
                            chatBox.classList.remove('scale-95', 'opacity-0');
                            chatBox.classList.add('scale-100', 'opacity-100');
                        });
                        iconOpen.classList.add('hidden');
                        iconClose.classList.remove('hidden');
                    }
                });
            });
        </script>
    @endif

    <script>
        function openSidebar() {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.add('hidden');
            document.body.style.overflow = '';
        }
    </script>

</body>

</html>
