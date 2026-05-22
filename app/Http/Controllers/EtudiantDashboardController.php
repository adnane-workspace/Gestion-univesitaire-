<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtudiantDashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Votre profil étudiant n\'est pas encore configuré. Contactez l\'administration.');
        }

        return view('etudiant.dashboard', compact('student'));
    }

    public function grades()
    {
        $student = Auth::user()->student;
        if (!$student) {
            return redirect()->route('login')->with('error', 'Profil étudiant non trouvé.');
        }

        $grades = $student->grades()
            ->with(['moduleElement.module'])
            ->get()
            ->groupBy(function($grade) {
                return $grade->moduleElement->module->name;
            });

        return view('etudiant.grades', compact('grades'));
    }

    public function modules()
    {
        $student = Auth::user()->student;
        if (!$student) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Votre profil étudiant n\'est pas configuré.');
        }
        $modules = $student->filiere->modules()->with('professors')->get();
        return view('etudiant.modules', compact('modules'));
    }

    public function schedule()
    {
        $student = Auth::user()->student;
        if (!$student) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Votre profil étudiant n\'est pas configuré.');
        }
        $schedules = \App\Models\Schedule::whereHas('module', function($q) use ($student) {
            $q->where('filiere_id', $student->filiere_id);
        })->with(['module', 'room', 'professor'])->orderBy('day')->orderBy('start_time')->get();

        return view('etudiant.schedule', compact('schedules', 'student'));
    }

    public function chatbotQuery(Request $request)
    {
        $student = Auth::user()->student;
        if (!$student) {
            return response()->json(['reply' => 'Profil étudiant introuvable.'], 403);
        }

        $query = strtolower($request->validate(['query' => 'required|string'])['query']);
        
        $reply = '<div class="space-y-2 bg-white/50 border border-slate-100/80 rounded-2xl p-4 shadow-sm text-center py-5">' .
                 '<span class="text-2xl mb-1 block">🤔</span>' .
                 '<p class="text-sm font-black text-slate-800">Je n’ai pas bien compris votre demande.</p>' .
                 '<p class="text-xs text-slate-600 font-semibold leading-relaxed max-w-[90%] mx-auto">' .
                 'Essayez d’utiliser les boutons rapides ci-dessous ou demandez-moi : **emploi du temps**, **mes notes**, **ma moyenne** ou **mes absences**.' .
                 '</p>' .
                 '</div>';

        if (preg_match('/^(bonjour|salut|hello|hey|coucou|aide|qui es-tu|help|bonsoir|yo|commencer|start)/i', $query)) {
            $reply = '<div class="space-y-3.5 bg-white/50 border border-slate-100/80 rounded-2xl p-4 shadow-sm">' .
                     '<p class="font-black text-slate-800 text-base flex items-center gap-1.5">' .
                     'Bonjour <span class="text-indigo-600">' . e($student->first_name) . '</span> ! 👋' .
                     '</p>' .
                     '<p class="text-sm text-slate-700 font-semibold leading-relaxed">Je suis ton assistant virtuel premium. Je peux t’aider à consulter instantanément :</p>' .
                     '<div class="grid grid-cols-2 gap-2.5 pt-1">' .
                     '<div class="p-3 bg-indigo-50/50 border border-indigo-100/40 rounded-xl flex items-center gap-2 shadow-sm">' .
                     '<span class="text-xl">📅</span>' .
                     '<div class="min-w-0"><p class="text-xs font-black text-indigo-700 leading-tight">Planning</p><p class="text-[11px] text-slate-500 font-semibold truncate">Emploi du jour</p></div>' .
                     '</div>' .
                     '<div class="p-3 bg-emerald-50/50 border border-emerald-100/40 rounded-xl flex items-center gap-2 shadow-sm">' .
                     '<span class="text-xl">📝</span>' .
                     '<div class="min-w-0"><p class="text-xs font-black text-emerald-700 leading-tight">Notes</p><p class="text-[11px] text-slate-500 font-semibold truncate">Derniers scores</p></div>' .
                     '</div>' .
                     '<div class="p-3 bg-amber-50/50 border border-amber-100/40 rounded-xl flex items-center gap-2 shadow-sm">' .
                     '<span class="text-xl">📊</span>' .
                     '<div class="min-w-0"><p class="text-xs font-black text-amber-700 leading-tight">Moyenne</p><p class="text-[11px] text-slate-500 font-semibold truncate">GPA & Progrès</p></div>' .
                     '</div>' .
                     '<div class="p-3 bg-rose-50/50 border border-rose-100/40 rounded-xl flex items-center gap-2 shadow-sm">' .
                     '<span class="text-xl">⚠️</span>' .
                     '<div class="min-w-0"><p class="text-xs font-black text-rose-700 leading-tight">Absences</p><p class="text-[11px] text-slate-500 font-semibold truncate">Justifications</p></div>' .
                     '</div>' .
                     '</div>' .
                     '<p class="text-xs text-slate-500 font-bold text-center border-t border-slate-150 pt-2.5 mt-1">Sélectionne un raccourci ci-dessous ou écris ton message !</p>' .
                     '</div>';
        } elseif (preg_match('/(emploi|planning|horaire|cours|calendrier|classe|plannings|emplois|horaires|agenda|programme)/i', $query)) {
            $today = \Carbon\Carbon::now()->locale('fr')->dayName;
            $schedule = \App\Models\Schedule::whereHas('module', function ($q) use ($student) {
                $q->where('filiere_id', $student->filiere_id);
            })->where('day', ucfirst($today))->with(['module', 'room', 'professor'])->orderBy('start_time')->get();

            if ($schedule->isEmpty()) {
                $reply = '<div class="flex flex-col items-center py-6 text-center bg-white/50 border border-slate-100/80 rounded-2xl p-4 shadow-sm">' .
                         '<span class="text-3xl mb-2 animate-bounce">🎉</span>' .
                         '<p class="font-black text-slate-700 text-sm">Aucun cours aujourd’hui !</p>' .
                         '<p class="text-xs text-slate-500 font-semibold mt-0.5">Profite de ta journée libre pour te reposer ou réviser.</p>' .
                         '</div>';
            } else {
                $lines = $schedule->map(function ($item) {
                    $startTime = \Carbon\Carbon::parse($item->start_time)->format('H:i');
                    $endTime = \Carbon\Carbon::parse($item->end_time)->format('H:i');
                    return '<div class="p-3 bg-white border border-slate-100/80 rounded-xl space-y-2 shadow-sm hover:shadow-md transition-all duration-200">' .
                           '<div class="flex items-center justify-between flex-wrap gap-1.5">' .
                           '<span class="text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-100/50 px-2.5 py-0.5 rounded-full shadow-sm">' . e($startTime) . ' - ' . e($endTime) . '</span>' .
                           '<span class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-100/50 px-2 py-0.5 rounded-full shadow-sm">📍 ' . e($item->room->name) . '</span>' .
                           '</div>' .
                           '<p class="text-sm font-bold text-slate-800 leading-snug">' . e($item->module->name) . '</p>' .
                           '<div class="flex items-center gap-1.5">' .
                           '<span class="text-xs font-bold text-violet-700 bg-violet-50 border border-violet-100/50 px-2 py-0.5 rounded-full shadow-sm">👤 ' . e($item->professor->first_name) . ' ' . e($item->professor->last_name) . '</span>' .
                           '</div>' .
                           '</div>';
                });
                $reply = '<div class="space-y-3">' .
                         '<p class="font-black text-slate-700 border-b border-slate-100 pb-1.5 flex items-center gap-1.5 text-sm">📅 Planning d’aujourd’hui :</p>' .
                         '<div class="space-y-2.5">' . $lines->join('') . '</div>' .
                         '</div>';
            }
        } elseif (preg_match('/(note|notes|résultat|résultats|score|scores|bulletin|examen|examens|contrôle|contrôles|devoir|devoirs|évaluation|évaluations)/i', $query)) {
            $grades = $student->grades()->with(['moduleElement.module'])->latest()->take(5)->get();
            if ($grades->isEmpty()) {
                $reply = '<div class="py-5 text-center text-slate-500 italic text-sm font-semibold bg-white/50 border border-slate-100/80 rounded-2xl shadow-sm">Aucune note n’a été enregistrée pour le moment.</div>';
            } else {
                $lines = $grades->map(function ($grade) {
                    $score = number_format($grade->score, 1);
                    $badgeClass = $grade->score >= 10 
                        ? 'bg-emerald-50 text-emerald-700 border-emerald-200/60' 
                        : 'bg-rose-50 text-rose-700 border-rose-200/60';
                    return '<div class="flex items-center justify-between p-3 bg-white border border-slate-100/80 rounded-xl hover:shadow-md transition-all duration-200">' .
                           '<div class="flex-1 pr-2 min-w-0">' .
                           '<p class="text-[10px] font-black uppercase tracking-wider text-slate-500 leading-none mb-1 truncate">' . e($grade->moduleElement->module->name) . '</p>' .
                           '<p class="text-sm font-bold text-slate-800 leading-snug truncate">' . e($grade->moduleElement->name) . '</p>' .
                           '</div>' .
                           '<div class="w-10 h-10 shrink-0 font-bold text-sm border rounded-xl flex flex-col items-center justify-center shadow-sm ' . $badgeClass . '">' .
                           '<span class="text-sm leading-none">' . e($score) . '</span>' .
                           '<span class="text-[10px] opacity-75 mt-0.5">/20</span>' .
                           '</div>' .
                           '</div>';
                });
                $reply = '<div class="space-y-3">' .
                         '<p class="font-black text-slate-700 border-b border-slate-100 pb-1.5 text-sm">📝 Notes récentes :</p>' .
                         '<div class="space-y-2.5">' . $lines->join('') . '</div>' .
                         '</div>';
            }
        } elseif (preg_match('/(moyen|moyenne|moyennes|gpa|g.p.a)/i', $query)) {
            $gpa = $student->calculateGPA();
            $gpaFormatted = number_format($gpa, 2);
            
            $colorClass = 'from-indigo-500 to-indigo-600 shadow-indigo-100';
            $emoji = '🚀';
            $phrase = 'Excellent travail, continue ainsi !';
            if ($gpa < 10) {
                $colorClass = 'from-rose-500 to-rose-600 shadow-rose-100';
                $emoji = '💪';
                $phrase = 'Ne te décourage pas, redouble d’efforts !';
            } elseif ($gpa < 14) {
                $colorClass = 'from-amber-500 to-amber-600 shadow-amber-100';
                $emoji = '👍';
                $phrase = 'Bon travail ! Tu peux faire encore mieux.';
            }
            
            $reply = '<div class="bg-gradient-to-br ' . $colorClass . ' text-white p-4.5 rounded-2xl shadow-lg space-y-2.5 border border-white/10 relative overflow-hidden">' .
                     '<div class="absolute -right-6 -bottom-6 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>' .
                     '<div class="flex items-center justify-between relative z-10">' .
                     '<span class="text-xs font-bold uppercase tracking-wider bg-white/20 px-3 py-1 rounded-full backdrop-blur-md">Moyenne Générale</span>' .
                     '<span class="text-xl animate-bounce">' . $emoji . '</span>' .
                     '</div>' .
                     '<div class="relative z-10 py-1">' .
                     '<p class="text-3xl font-black tracking-tight">' . e($gpaFormatted) . ' <span class="text-sm font-semibold opacity-85">/ 20</span></p>' .
                     '</div>' .
                     '<p class="text-xs font-semibold opacity-95 leading-relaxed border-t border-white/20 pt-2 flex items-center gap-1.5 relative z-10">' .
                     '✨ ' . $phrase .
                     '</p>' .
                     '</div>';
        } elseif (preg_match('/(absence|absences|manqué|retard|retards|cours manqué|cours manqués|assiduité)/i', $query)) {
            $absences = \App\Models\Absence::where('student_id', $student->id)->get();
            if ($absences->isEmpty()) {
                $reply = '<div class="flex flex-col items-center py-6 text-center bg-white/50 border border-slate-100/80 rounded-2xl p-4 shadow-sm">' .
                         '<span class="text-3xl mb-2">⭐</span>' .
                         '<p class="font-black text-slate-700 text-sm">Aucune absence enregistrée !</p>' .
                         '<p class="text-xs text-emerald-700 font-bold bg-emerald-50/80 px-3.5 py-1.5 rounded-full mt-2 shadow-sm border border-emerald-100">Félicitations pour ton assiduité</p>' .
                         '</div>';
            } else {
                $lines = $absences->map(function ($absence) {
                    $dateStr = $absence->date->format('d/m/Y');
                    $excusedBadge = $absence->excused 
                        ? '<span class="text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200/60 px-2.5 py-0.5 rounded-full shadow-sm">Justifiée</span>'
                        : '<span class="text-[10px] font-bold uppercase tracking-wider bg-rose-50 text-rose-700 border border-rose-200/60 px-2.5 py-0.5 rounded-full shadow-sm">Non justifiée</span>';
                    return '<div class="p-3 bg-white border border-slate-100/80 rounded-xl space-y-2 shadow-sm hover:shadow-md transition-all duration-200">' .
                           '<div class="flex items-center justify-between flex-wrap gap-1.5">' .
                           '<span class="text-xs font-bold text-slate-700 bg-slate-50 border border-slate-200/60 px-2.5 py-0.5 rounded-full shadow-sm">📅 ' . e($dateStr) . '</span>' .
                           $excusedBadge .
                           '</div>' .
                           '<div class="text-xs text-slate-600 font-medium leading-normal bg-slate-50/50 p-2 rounded-lg border border-slate-100">' .
                           'Motif : <strong class="text-slate-700 font-bold">' . e($absence->reason ?? 'Non renseigné') . '</strong>' .
                           '</div>' .
                           '</div>';
                });
                $reply = '<div class="space-y-3">' .
                         '<p class="font-black text-slate-700 border-b border-slate-100 pb-1.5 text-sm">⚠️ Tes Absences :</p>' .
                         '<div class="space-y-2.5">' . $lines->join('') . '</div>' .
                         '</div>';
            }
        }

        return response()->json(['reply' => $reply]);
    }
}
