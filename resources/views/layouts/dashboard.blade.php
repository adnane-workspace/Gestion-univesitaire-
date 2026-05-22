<!DOCTYPE html>
<html lang="fr" class="h-full bg-[#F8FAFC]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | EduPortal UPF</title>
    <meta name="description" content="Plateforme de gestion académique de l'Université Panafricaine.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    @vite(['resources/js/app.js'])
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
    @if(Auth::check() && Auth::user()->role === 'etudiant')
        <!-- Floating Chatbot Toggle Button & Widget -->
        <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3" id="chatbot-floating-container">
            <!-- Chatbot box -->
            <div id="chatbot-box" class="hidden w-[480px] max-w-[calc(100vw-2rem)] bg-white/95 backdrop-blur-md rounded-[2.5rem] border border-slate-200/50 shadow-2xl overflow-hidden transition-all duration-300 transform scale-95 opacity-0 origin-bottom-right">
                <div id="app"></div>
            </div>
            
            <!-- Toggle Button -->
            <button id="chatbot-toggle-btn" class="w-14 h-14 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white flex items-center justify-center shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition-all hover:scale-105 active:scale-95 cursor-pointer relative group">
                <!-- Unread pulse -->
                <span class="absolute -top-0.5 -right-0.5 flex h-3.5 w-3.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-emerald-500 border-2 border-white"></span>
                </span>
                <!-- Chat bubble icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-all duration-300" id="chatbot-icon-open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                <!-- Close icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden transition-all duration-300" id="chatbot-icon-close" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                    if (chatBox.classList.contains('hidden')) {
                        // Show
                        chatBox.classList.remove('hidden');
                        setTimeout(() => {
                            chatBox.classList.remove('scale-95', 'opacity-0');
                            chatBox.classList.add('scale-100', 'opacity-100');
                        }, 20);
                        iconOpen.classList.add('hidden');
                        iconClose.classList.remove('hidden');
                    } else {
                        // Hide
                        chatBox.classList.remove('scale-100', 'opacity-100');
                        chatBox.classList.add('scale-95', 'opacity-0');
                        setTimeout(() => {
                            chatBox.classList.add('hidden');
                        }, 300);
                        iconOpen.classList.remove('hidden');
                        iconClose.classList.add('hidden');
                    }
                });
            });
        </script>
    @endif
</body>

</html>