<!DOCTYPE html>
<html lang="fr" class="h-full bg-[#F8FAFC]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - EduPortal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Geist', 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .sidebar-link {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-active {
            background: #EEF2FF;
            color: #4F46E5;
            box-shadow: inset 4px 0 0 #4F46E5;
        }
    </style>
</head>

<body class="h-full">
    <div class="flex h-full overflow-hidden">
        <!-- Sidebar -->
        <aside class="hidden lg:flex flex-col w-72 bg-white border-r border-slate-200 shrink-0">
            <div class="p-8 flex items-center justify-center">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-16 object-contain">
            </div>

            <nav class="flex-1 px-4 space-y-1 mt-4">
                <div class="px-4 mb-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Navigation</div>
                @yield('sidebar-links')
            </nav>

            <div class="p-6 border-t border-slate-100">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 px-4 py-3 w-full rounded-xl hover:bg-slate-50 text-slate-500 hover:text-rose-600 transition-all font-bold text-sm group">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 opacity-50 group-hover:opacity-100 transition-opacity" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#F8FAFC]">
            <!-- Header -->
            <header
                class="bg-white border-b border-slate-200/60 h-20 flex items-center justify-between px-10 shrink-0 sticky top-0 z-20">
                <div class="flex items-center gap-4">
                    <button class="lg:hidden p-2 text-slate-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-xl font-bold text-[#1E293B]">@yield('title')</h1>
                </div>

                <div class="flex items-center gap-6">
                    <div class="hidden md:flex flex-col text-right">
                        <p class="text-sm font-bold text-[#1E293B]">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] font-black text-[#4F46E5] uppercase tracking-widest">
                            {{ Auth::user()->role }}</p>
                    </div>
                    <div
                        class="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-center text-[#1E293B] font-bold text-lg shadow-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto">
                <div class="p-10 max-w-[1600px] mx-auto">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</body>

</html>