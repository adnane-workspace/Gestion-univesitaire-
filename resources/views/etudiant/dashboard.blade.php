@extends('layouts.dashboard')

@section('title', 'Mon Espace Étudiant')

@section('sidebar-links')
    <a href="{{ route('etudiant.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('etudiant.dashboard') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        Tableau de bord
    </a>
    <a href="{{ route('etudiant.modules') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('etudiant.modules') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        Mes Modules
    </a>
    <a href="{{ route('etudiant.grades') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('etudiant.grades') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
        Mes Notes
    </a>
    <a href="{{ route('etudiant.schedule') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('etudiant.schedule') ? 'sidebar-active shadow-sm' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }} transition-all font-bold text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Emploi du temps
    </a>
@endsection

@section('content')
    <!-- Welcome Header -->
    <div class="relative overflow-hidden bg-indigo-600 rounded-[2.5rem] p-10 mb-10 shadow-2xl shadow-indigo-200">
        <div class="relative z-10">
            <h2 class="text-4xl font-black text-white mb-2">Bonjour, {{ $student->first_name }} ! 👋</h2>
            <p class="text-indigo-100 text-lg font-medium">Bonne chance pour vos cours d'aujourd'hui.</p>
            
            <div class="flex gap-6 mt-8">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl px-6 py-3 border border-white/20">
                    <p class="text-[10px] font-black uppercase tracking-widest text-indigo-200">Moyenne Actuelle</p>
                    <p class="text-2xl font-black text-white">{{ number_format($student->grades->avg('score') ?? 0, 2) }} <span class="text-xs opacity-60">/ 20</span></p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl px-6 py-3 border border-white/20">
                    <p class="text-[10px] font-black uppercase tracking-widest text-indigo-200">Absences</p>
                    <p class="text-2xl font-black text-white">0 <span class="text-xs opacity-60">heures</span></p>
                </div>
            </div>
            <div class="mt-8">
                <a href="{{ route('etudiant.bulletin.pdf') }}" class="inline-flex items-center justify-center rounded-3xl bg-white text-indigo-700 font-bold px-6 py-3 shadow-lg shadow-indigo-200/30 hover:bg-slate-100 transition">
                    Télécharger mon bulletin PDF
                </a>
            </div>
        </div>
        
        <!-- Decoration -->
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/4 w-64 h-64 bg-indigo-400/20 rounded-full blur-2xl"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 space-y-10">
            <!-- Schedule Widget -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200/60 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/30">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Planning du jour
                    </h3>
                    <a href="{{ route('etudiant.schedule') }}" class="text-sm font-bold text-indigo-600 hover:underline">Voir tout le calendrier</a>
                </div>
                <div class="p-8">
                    @php
                        $today = \Carbon\Carbon::now()->locale('fr')->dayName;
                        $todaySchedule = \App\Models\Schedule::whereHas('module', function($q) use ($student) {
                            $q->where('filiere_id', $student->filiere_id);
                        })->where('day', ucfirst($today))->with(['module', 'room', 'professor'])->orderBy('start_time')->get();
                    @endphp

                    @if($todaySchedule->isEmpty())
                        <div class="py-10 text-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <p class="text-slate-400 font-bold italic">Pas de cours aujourd'hui ! Profitez-en.</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($todaySchedule as $item)
                                <div class="group flex items-center gap-6 p-6 rounded-[2rem] bg-slate-50 border border-slate-100 hover:border-indigo-200 hover:bg-white transition-all hover:shadow-xl hover:shadow-indigo-50">
                                    <div class="text-center min-w-[70px]">
                                        <p class="text-lg font-black text-slate-800 group-hover:text-indigo-600 transition-colors">{{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}</p>
                                        <div class="h-1.5 w-full bg-indigo-100 rounded-full mt-2 overflow-hidden">
                                            <div class="h-full bg-indigo-500 w-1/2"></div>
                                        </div>
                                    </div>
                                    <div class="w-px h-12 bg-slate-200"></div>
                                    <div class="flex-1">
                                        <p class="font-black text-slate-800 text-lg">{{ $item->module->name }}</p>
                                        <div class="flex items-center gap-4 mt-1">
                                            <span class="flex items-center gap-1 text-xs font-bold text-slate-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                </svg>
                                                {{ $item->room->name }}
                                            </span>
                                            <span class="flex items-center gap-1 text-xs font-bold text-indigo-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Prof. {{ $item->professor->last_name }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Grades -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200/60 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-slate-800">Résultats récents</h3>
                    <a href="{{ route('etudiant.grades') }}" class="text-sm font-bold text-indigo-600 hover:underline">Relevé complet</a>
                </div>
                <div class="p-8">
                    @php
                        $recentGrades = $student->grades()->with(['moduleElement.module'])->latest()->take(4)->get();
                    @endphp
                    
                    @if($recentGrades->isEmpty())
                        <p class="text-center text-slate-400 italic">Aucune note saisie pour le moment.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($recentGrades as $grade)
                                <div class="p-6 rounded-[2rem] border border-slate-100 bg-slate-50/20 flex items-center justify-between hover:border-indigo-100 transition-all">
                                    <div>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">{{ $grade->moduleElement->module->name }}</p>
                                        <p class="font-bold text-slate-700">{{ $grade->moduleElement->name }}</p>
                                    </div>
                                    <div class="w-14 h-14 rounded-2xl {{ $grade->score >= 10 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} flex items-center justify-center font-black text-lg border {{ $grade->score >= 10 ? 'border-emerald-100' : 'border-rose-100' }}">
                                        {{ number_format($grade->score, 1) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="space-y-10">
            <!-- Profile Card -->
            <div class="bg-white rounded-[2.5rem] border border-slate-200/60 shadow-sm p-8 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                <div class="relative mt-8">
                    <div class="w-24 h-24 rounded-[2rem] bg-white p-1 mx-auto mb-4 shadow-xl shadow-indigo-100">
                        <div class="w-full h-full rounded-[1.8rem] bg-indigo-50 flex items-center justify-center text-3xl font-black text-indigo-600">
                            {{ substr($student->first_name, 0, 1) }}
                        </div>
                    </div>
                    <h4 class="text-xl font-black text-slate-800">{{ $student->first_name }} {{ $student->last_name }}</h4>
                    <p class="text-sm font-bold text-indigo-600 mt-1 uppercase tracking-widest">{{ $student->filiere->code }}</p>
                    
                    <div class="mt-8 pt-8 border-t border-slate-100 space-y-4 text-left">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-400">Niveau</span>
                            <span class="text-xs font-black text-slate-700 uppercase">Semestre 6</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-400">Matricule</span>
                            <span class="text-xs font-black text-slate-700">{{ $student->student_id_number }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-400">Email</span>
                            <span class="text-xs font-black text-slate-700">{{ Str::limit($student->email, 20) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Infos Pratiques & Support -->
            <div class="bg-gradient-to-br from-slate-900 to-indigo-950 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-xl">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-2xl"></div>
                <h3 class="text-xs font-black uppercase tracking-widest text-indigo-300 mb-2">Guide de l'Étudiant</h3>
                <h4 class="text-lg font-black mb-3 flex items-center gap-2">
                    🎓 Besoin d'une information ?
                </h4>
                <p class="text-xs text-slate-400 leading-relaxed mb-6">
                    Accédez en temps réel à votre planning, vos notes et vos absences depuis votre portail. Pour toute autre question, votre assistant virtuel intelligent est disponible en bas à droite !
                </p>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-[10px] font-bold text-slate-300 bg-white/5 border border-white/10 p-3 rounded-2xl">
                        <span>📌</span>
                        <span>Bureau de scolarité ouvert de 08:30 à 17:00</span>
                    </div>
                    <div class="flex items-center gap-3 text-[10px] font-bold text-slate-300 bg-white/5 border border-white/10 p-3 rounded-2xl">
                        <span>📞</span>
                        <span>Contact direct : contact.scolarite@upf.ma</span>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white">
                <h4 class="font-black text-lg mb-6">Récapitulatif</h4>
                <div class="space-y-6">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Modules validés</span>
                            <span class="text-xs font-black">75%</span>
                        </div>
                        <div class="h-2 w-full bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 w-3/4"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Assiduité</span>
                            <span class="text-xs font-black">100%</span>
                        </div>
                        <div class="h-2 w-full bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-500 w-full"></div>
                        </div>
                    </div>
                </div>
                
                <button class="w-full mt-10 py-4 rounded-2xl bg-indigo-600 hover:bg-indigo-700 transition-all font-black text-sm shadow-xl shadow-indigo-900/50">
                    Générer Certificat
                </button>
            </div>
        </div>
    </div>
@endsection
