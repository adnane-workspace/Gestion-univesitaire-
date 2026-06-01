<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Administration UPF</title>
    <meta name="description" content="Espace d'administration de l'Université Panafricaine.">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Geist', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
            background: #F8FAFC;
            color: #0F172A;
        }
        :focus-visible { outline: 2px solid #4F46E5; outline-offset: 2px; border-radius: 8px; }

        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 999px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }

        .sidebar-link { transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); position: relative; }
        .sidebar-active {
            background: linear-gradient(135deg, rgba(79,70,229,0.08), rgba(99,102,241,0.04));
            color: #4F46E5;
            font-weight: 700;
        }
        .sidebar-active::before {
            content: '';
            position: absolute;
            left: 0; top: 50%; transform: translateY(-50%);
            width: 3px; height: 60%;
            background: #4F46E5;
            border-radius: 0 4px 4px 0;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .anim-fade-down { animation: fadeInDown 0.3s ease-out both; }
    </style>
</head>

<body class="h-full">

    {{-- Mobile sidebar overlay --}}
    <div id="admin-sidebar-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden lg:hidden" onclick="closeAdminSidebar()"></div>

    <div class="flex h-full overflow-hidden">

        {{-- ═══════════════════════════════════════ SIDEBAR ═══════════════════════════════════════ --}}
        <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-[260px] bg-white border-r border-slate-200 flex flex-col transform -translate-x-full lg:translate-x-0 lg:static lg:z-auto transition-transform duration-300 ease-out">

            {{-- Logo --}}
            <div class="px-6 py-5 flex items-center gap-3 border-b border-slate-100 shrink-0">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center shadow-md shrink-0">
                    <span class="text-white font-black text-sm">A</span>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-black text-slate-900 leading-none tracking-tight">Admin</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">UPF</p>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
                <p class="px-3 mb-3 text-[10px] font-black uppercase tracking-[0.15em] text-slate-400">Administration</p>

                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Tableau de bord
                </a>

                <a href="{{ route('admin.students.index') }}" class="sidebar-link {{ request()->routeIs('admin.students.*') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Étudiants
                </a>

                <a href="{{ route('admin.professors.index') }}" class="sidebar-link {{ request()->routeIs('admin.professors.*') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    Professeurs
                </a>

                <a href="{{ route('admin.filieres.index') }}" class="sidebar-link {{ request()->routeIs('admin.filieres.*') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Filières
                </a>

                <a href="{{ route('admin.modules.index') }}" class="sidebar-link {{ request()->routeIs('admin.modules.*') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Modules
                </a>

                <a href="{{ route('admin.rooms.index') }}" class="sidebar-link {{ request()->routeIs('admin.rooms.*') ? 'sidebar-active' : 'text-slate-500 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    Salles
                </a>
            </nav>

            {{-- Logout --}}
            <div class="px-3 py-4 border-t border-slate-100 shrink-0">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-link flex items-center gap-3 px-3 py-2.5 w-full rounded-xl text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition-all font-bold text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        {{-- ═══════════════════════════════════════ MAIN ═══════════════════════════════════════ --}}
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">

            {{-- Header --}}
            <header class="bg-white/80 backdrop-blur-lg border-b border-slate-200 h-14 flex items-center justify-between px-4 lg:px-8 shrink-0 sticky top-0 z-30">
                <div class="flex items-center gap-3">
                    <button onclick="openAdminSidebar()" class="lg:hidden p-1.5 -ml-1.5 rounded-lg text-slate-500 hover:bg-slate-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h1 class="text-base font-black text-slate-900 tracking-tight">@yield('title')</h1>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col items-end">
                        <p class="text-xs font-bold text-slate-900 leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.15em] mt-0.5">Administrateur</p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center text-white font-bold text-xs shadow-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            {{-- Scrollable Content --}}
            <div class="flex-1 overflow-y-auto">
                <div class="p-4 lg:p-6 xl:p-8 max-w-[1400px] mx-auto">

                    @if(session('success'))
                        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-3 anim-fade-down">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-sm font-bold">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-rose-100 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </div>
                            <span class="text-sm font-bold">{{ session('error') }}</span>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <script>
        function openAdminSidebar() {
            document.getElementById('admin-sidebar').classList.remove('-translate-x-full');
            document.getElementById('admin-sidebar-overlay').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeAdminSidebar() {
            document.getElementById('admin-sidebar').classList.add('-translate-x-full');
            document.getElementById('admin-sidebar-overlay').classList.add('hidden');
            document.body.style.overflow = '';
        }
    </script>

</body>

</html>
