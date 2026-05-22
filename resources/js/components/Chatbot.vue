<template>
    <div class="flex flex-col h-[580px] bg-slate-50/30 backdrop-blur-md rounded-3xl border border-slate-100/80 p-4 shadow-sm relative overflow-hidden">
        <!-- Chat Status Header -->
        <div class="flex items-center justify-between pb-3 border-b border-slate-100/80 mb-3 shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-2xl bg-gradient-to-tr from-indigo-500 to-indigo-600 flex items-center justify-center text-md shadow-md shadow-indigo-100 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 opacity-20 transform -skew-x-12"></div>
                    <span class="relative z-10">🤖</span>
                </div>
                <div>
                    <h4 class="text-sm font-black text-slate-800 leading-tight">EduBot Pro</h4>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
                        </span>
                        <span class="text-[11px] font-black text-emerald-600 uppercase tracking-wider">En ligne</span>
                    </div>
                </div>
            </div>
            <button @click="resetChat" class="p-1.5 text-slate-400 hover:text-rose-500 hover:bg-rose-50/50 rounded-xl transition-all cursor-pointer animate-fade-in" title="Réinitialiser la discussion">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>

        <!-- Chat Messages Container -->
        <div 
            ref="chatContainer"
            class="flex-1 overflow-y-auto pr-1 space-y-4 mb-3 scrollbar-thin max-h-[420px]"
        >
            <div
                v-for="(m, idx) in messages"
                :key="idx"
                class="flex"
                :class="m.from === 'user' ? 'justify-end' : 'justify-start'"
            >
                <!-- Bot Bubble -->
                <div
                    v-if="m.from === 'bot'"
                    class="max-w-[90%] bg-white border border-slate-100/95 rounded-2xl rounded-tl-none p-3.5 text-slate-800 text-sm font-medium leading-relaxed shadow-sm animate-fade-in w-full hover:border-slate-200/50 transition-colors"
                    v-html="m.text"
                ></div>

                <!-- User Bubble -->
                <div
                    v-else
                    class="max-w-[80%] bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-2xl rounded-tr-none p-3 px-4.5 text-sm font-medium leading-relaxed shadow-md shadow-indigo-100/80 animate-slide-up"
                >
                    {{ m.text }}
                </div>
            </div>

            <!-- Typing Indicator -->
            <div v-if="isTyping" class="flex justify-start">
                <div class="bg-white border border-slate-100 rounded-2xl rounded-tl-none p-3.5 px-4.5 flex gap-1 items-center shadow-sm">
                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                </div>
            </div>
        </div>

        <!-- Suggestion Pills -->
        <div class="flex flex-wrap gap-1.5 mb-2.5 shrink-0">
            <button 
                v-for="pill in suggestionPills" 
                :key="pill.query"
                @click="sendQuery(pill.query)"
                class="text-xs font-bold text-slate-700 hover:text-indigo-700 bg-white hover:bg-indigo-50/60 border border-slate-200 hover:border-indigo-300 px-3.5 py-2 rounded-full transition-all flex items-center gap-1.5 shadow-sm cursor-pointer hover:scale-[1.03] active:scale-[0.98] duration-150"
            >
                <span>{{ pill.icon }}</span>
                <span>{{ pill.label }}</span>
            </button>
        </div>

        <!-- Chat Input Form -->
        <div class="flex gap-2 items-center shrink-0">
            <input
                v-model="input"
                @keyup.enter="send"
                :disabled="isTyping"
                placeholder="Écris ton message ici..."
                class="flex-1 px-4 py-3 border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 rounded-xl text-sm font-semibold text-slate-800 bg-white placeholder-slate-400 focus:bg-white transition-all disabled:opacity-60 shadow-sm"
            />
            <button
                @click="send"
                :disabled="isTyping"
                class="p-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm transition-all shadow-md shadow-indigo-200 hover:shadow-indigo-300 disabled:opacity-60 flex items-center justify-center shrink-0 cursor-pointer hover:scale-[1.03] active:scale-[0.97]"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            input: "",
            isTyping: false,
            messages: [
                {
                    from: "bot",
                    text: `<div class="space-y-3.5 bg-white/50 rounded-2xl p-0">
                        <p class="font-black text-slate-800 text-base flex items-center gap-1.5">
                            Bonjour ! 👋
                        </p>
                        <p class="text-sm text-slate-700 font-semibold leading-relaxed">Je suis ton assistant virtuel premium. Je peux t’aider à consulter instantanément :</p>
                        <div class="grid grid-cols-2 gap-2.5 pt-1">
                            <div class="p-3 bg-indigo-50/50 border border-indigo-100/40 rounded-xl flex items-center gap-2 shadow-sm">
                                <span class="text-xl">📅</span>
                                <div class="min-w-0"><p class="text-xs font-black text-indigo-700 leading-tight">Planning</p><p class="text-[11px] text-slate-500 font-semibold truncate">Emploi du jour</p></div>
                            </div>
                            <div class="p-3 bg-emerald-50/50 border border-emerald-100/40 rounded-xl flex items-center gap-2 shadow-sm">
                                <span class="text-xl">📝</span>
                                <div class="min-w-0"><p class="text-xs font-black text-emerald-700 leading-tight">Notes</p><p class="text-[11px] text-slate-500 font-semibold truncate">Derniers scores</p></div>
                            </div>
                            <div class="p-3 bg-amber-50/50 border border-amber-100/40 rounded-xl flex items-center gap-2 shadow-sm">
                                <span class="text-xl">📊</span>
                                <div class="min-w-0"><p class="text-xs font-black text-amber-700 leading-tight">Moyenne</p><p class="text-[11px] text-slate-500 font-semibold truncate">GPA & Progrès</p></div>
                            </div>
                            <div class="p-3 bg-rose-50/50 border border-rose-100/40 rounded-xl flex items-center gap-2 shadow-sm">
                                <span class="text-xl">⚠️</span>
                                <div class="min-w-0"><p class="text-xs font-black text-rose-700 leading-tight">Absences</p><p class="text-[11px] text-slate-500 font-semibold truncate">Justifications</p></div>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 font-bold text-center border-t border-slate-150 pt-2.5 mt-1">Sélectionne un raccourci ci-dessous ou écris ton message !</p>
                    </div>`,
                },
            ],
            suggestionPills: [
                { icon: "📅", label: "Planning du jour", query: "planning du jour" },
                { icon: "📊", label: "Ma moyenne", query: "ma moyenne" },
                { icon: "📝", label: "Mes notes", query: "mes notes" },
                { icon: "⚠️", label: "Mes absences", query: "mes absences" },
            ]
        };
    },
    mounted() {
        this.scrollToBottom();
    },
    methods: {
        async sendQuery(queryText) {
            this.input = queryText;
            await this.send();
        },
        async send() {
            const text = this.input.trim();
            if (!text || this.isTyping) return;

            this.messages.push({ from: "user", text });
            this.input = "";
            this.isTyping = true;
            
            // Multi-step scroll to capture keyboard / new layout changes
            this.scrollToBottom();

            try {
                const res = await fetch("/etudiant/chatbot/query", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ query: text }),
                });
                
                if (!res.ok) {
                    throw new Error(`Erreur ${res.status}`);
                }

                const data = await res.json();
                this.messages.push({ from: "bot", text: data.reply });
            } catch (e) {
                this.messages.push({ 
                    from: "bot", 
                    text: `<div class="p-3 bg-rose-50 border border-rose-100 rounded-xl text-rose-700 font-bold flex items-center gap-2 animate-fade-in">
                        <span class="text-base">⚠️</span>
                        <span>Erreur de communication : ${e.message}</span>
                    </div>` 
                });
            } finally {
                this.isTyping = false;
                this.scrollToBottom();
            }
        },
        resetChat() {
            this.messages = [
                {
                    from: "bot",
                    text: `<div class="space-y-3 bg-white/50 rounded-2xl p-0 animate-fade-in">
                        <p class="font-black text-slate-800 text-base flex items-center gap-1.5">
                            Discussion réinitialisée ! 🤖
                        </p>
                        <p class="text-sm text-slate-700 font-semibold leading-relaxed">Je suis prêt à t'aider. Quelle est ta demande ?</p>
                    </div>`,
                }
            ];
            this.scrollToBottom();
        },
        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.chatContainer;
                if (container) {
                    container.scrollTo({
                        top: container.scrollHeight,
                        behavior: "smooth",
                    });
                }
            });
            // Double-scroll timeout to prevent browser race-conditions on complex HTML rendering
            setTimeout(() => {
                const container = this.$refs.chatContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            }, 80);
        },
    },
};
</script>

<style scoped>
.scrollbar-thin::-webkit-scrollbar {
    width: 4px;
}
.scrollbar-thin::-webkit-scrollbar-track {
    background: transparent;
}
.scrollbar-thin::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 9999px;
}
.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: #cbd5e1;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(6px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(12px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.animate-fade-in {
    animation: fadeIn 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

.animate-slide-up {
    animation: slideUp 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>
