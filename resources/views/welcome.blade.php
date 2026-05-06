<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduPortal - Système de Gestion Académique de Nouvelle Génération</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Geist', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .text-gradient {
            background: linear-gradient(to right, #4F46E5, #9333EA);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 w-full z-50 p-6">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-8 py-4 glass rounded-[2rem] shadow-sm">
            <div class="flex items-center gap-3">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-10 object-contain">
            </div>
            
            <div class="hidden md:flex items-center gap-8 font-bold text-sm text-slate-500">
                <a href="#features" class="hover:text-[#4F46E5] transition-colors">Fonctionnalités</a>
                <a href="#about" class="hover:text-[#4F46E5] transition-colors">À propos</a>
                <a href="#contact" class="hover:text-[#4F46E5] transition-colors">Support</a>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    @php
                        $dashboardUrl = match(Auth::user()->role) {
                            'admin' => route('admin.dashboard'),
                            'professeur' => route('professeur.dashboard'),
                            'etudiant' => route('etudiant.dashboard'),
                            default => url('/dashboard'),
                        };
                    @endphp
                    <a href="{{ $dashboardUrl }}" class="px-6 py-2.5 rounded-xl bg-[#4F46E5] text-white font-bold text-sm shadow-xl shadow-indigo-200 hover:bg-[#4338CA] transition-all">
                        Tableau de bord
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-xl font-bold text-sm text-slate-600 hover:text-[#4F46E5] transition-all">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 rounded-xl bg-[#1E293B] text-white font-bold text-sm shadow-xl shadow-slate-200 hover:bg-black transition-all">
                        Inscription
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative pt-48 pb-32 px-6 overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 -z-10 translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-indigo-50 rounded-full blur-[120px] opacity-60"></div>
        <div class="absolute bottom-0 left-0 -z-10 -translate-x-1/4 translate-y-1/4 w-[600px] h-[600px] bg-purple-50 rounded-full blur-[100px] opacity-60"></div>

        <div class="max-w-7xl mx-auto text-center relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 border border-indigo-100 text-[#4F46E5] text-xs font-black uppercase tracking-widest mb-8">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
                Nouvelle version 2.0 disponible
            </div>
            <h1 class="text-6xl md:text-8xl font-black text-[#1E293B] leading-[1.1] tracking-tighter mb-8">
                L'avenir de la gestion <br />
                <span class="text-gradient uppercase tracking-widest text-4xl md:text-6xl block mt-4">Académique</span>
            </h1>
            <p class="max-w-2xl mx-auto text-xl text-slate-500 font-medium leading-relaxed mb-12">
                Simplifiez la vie de vos étudiants, professeurs et administrateurs avec une plateforme intuitive, robuste et sécurisée.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-10 py-5 rounded-2xl bg-[#4F46E5] text-white font-black text-lg shadow-2xl shadow-indigo-200 hover:scale-105 transition-all">
                    Commencer gratuitement
                </a>
                <a href="#features" class="w-full sm:w-auto px-10 py-5 rounded-2xl bg-white border border-slate-200 text-slate-700 font-black text-lg shadow-sm hover:bg-slate-50 transition-all flex items-center justify-center gap-2">
                    Découvrir les fonctionnalités
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-32 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-24">
                <h2 class="text-4xl font-black text-[#1E293B] mb-4">Une solution pour chaque profil</h2>
                <div class="w-20 h-1.5 bg-[#4F46E5] mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Admin Card -->
                <div class="bg-white p-12 rounded-[3rem] border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.02)] hover:shadow-xl hover:-translate-y-2 transition-all group">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-8 group-hover:bg-[#4F46E5] group-hover:text-white transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.754 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-[#1E293B] mb-4">Administration</h3>
                    <p class="text-slate-500 font-medium leading-relaxed">
                        Gestion complète des filières, modules, salles et emplois du temps avec une visibilité totale sur les effectifs.
                    </p>
                </div>

                <!-- Professor Card -->
                <div class="bg-white p-12 rounded-[3rem] border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.02)] hover:shadow-xl hover:-translate-y-2 transition-all group">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-8 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-[#1E293B] mb-4">Professeurs</h3>
                    <p class="text-slate-500 font-medium leading-relaxed">
                        Saisie rapide des notes par module et consultation simplifiée du planning hebdomadaire de cours.
                    </p>
                </div>

                <!-- Student Card -->
                <div class="bg-white p-12 rounded-[3rem] border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.02)] hover:shadow-xl hover:-translate-y-2 transition-all group">
                    <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-8 group-hover:bg-amber-600 group-hover:text-white transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-[#1E293B] mb-4">Étudiants</h3>
                    <p class="text-slate-500 font-medium leading-relaxed">
                        Consultation en temps réel des résultats académiques, de la progression et de l'emploi du temps du jour.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#1E293B] text-slate-400 py-24 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-12 object-contain">
                </div>
                <p class="max-w-sm mb-8">
                    La plateforme universitaire leader pour la transformation numérique de l'enseignement supérieur.
                </p>
                <div class="flex gap-4">
                    <!-- Social icons placeholders -->
                    <div class="w-10 h-10 rounded-full bg-slate-800 hover:bg-[#4F46E5] transition-colors cursor-pointer flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-1.017-2.178-1.652-3.594-1.652-2.719 0-4.923 2.204-4.923 4.923 0 .385.043.76.127 1.121-4.092-.206-7.72-2.165-10.148-5.144-.424.729-.666 1.577-.666 2.476 0 1.708.869 3.215 2.19 4.098-.807-.025-1.566-.248-2.229-.616v.062c0 2.385 1.697 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.317 0-.626-.03-.927-.086.627 1.956 2.444 3.379 4.604 3.419-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63.961-.689 1.8-1.56 2.46-2.548l-.047-.02z"/></svg>
                    </div>
                </div>
            </div>
            
            <div>
                <h4 class="text-white font-bold mb-6">Liens Rapides</h4>
                <ul class="space-y-4 text-sm">
                    <li><a href="#" class="hover:text-white transition-colors">Accueil</a></li>
                    <li><a href="#features" class="hover:text-white transition-colors">Fonctionnalités</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Connexion</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Inscription</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold mb-6">Ressources</h4>
                <ul class="space-y-4 text-sm">
                    <li><a href="#" class="hover:text-white transition-colors">Documentation</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">API</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Guides</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                </ul>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto mt-24 pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-xs font-bold uppercase tracking-widest text-slate-600">
                &copy; {{ date('Y') }} EduPortal Academic System. Conçu pour l'excellence.
            </p>
            <div class="flex gap-8 text-xs font-bold uppercase tracking-widest">
                <a href="#" class="hover:text-white transition-colors">Confidentialité</a>
                <a href="#" class="hover:text-white transition-colors">Conditions</a>
            </div>
        </div>
    </footer>
</body>
</html>
