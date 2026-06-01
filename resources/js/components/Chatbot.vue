<template>
    <div class="flex flex-col h-[520px] bg-white rounded-2xl border border-slate-200 shadow-2xl shadow-slate-200/50 overflow-hidden">

        <!-- Header -->
        <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between shrink-0 bg-white">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center shadow-md shadow-indigo-200/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></span>
                </div>
                <div>
                    <h4 class="text-sm font-black text-slate-900 leading-none">EduBot</h4>
                    <p class="text-[10px] font-bold text-emerald-600 mt-0.5">En ligne</p>
                </div>
            </div>
            <button @click="resetChat" class="p-1.5 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all" title="Réinitialiser">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>

        <!-- Messages -->
        <div ref="chatContainer" class="flex-1 overflow-y-auto px-4 py-3 space-y-3">
            <div v-for="(m, idx) in messages" :key="idx" class="flex" :class="m.from === 'user' ? 'justify-end' : 'justify-start'">
                <!-- Bot -->
                <div v-if="m.from === 'bot'" class="max-w-[88%]">
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl rounded-tl-md p-3 text-sm text-slate-700 leading-relaxed" v-html="m.text"></div>
                    <p class="text-[9px] font-bold text-slate-300 mt-1 ml-1">{{ m.time }}</p>
                </div>
                <!-- User -->
                <div v-else class="max-w-[80%]">
                    <div class="bg-indigo-600 text-white rounded-2xl rounded-tr-md px-4 py-2.5 text-sm font-medium leading-relaxed shadow-sm">
                        {{ m.text }}
                    </div>
                    <p class="text-[9px] font-bold text-slate-300 mt-1 mr-1 text-right">{{ m.time }}</p>
                </div>
            </div>

            <!-- Typing -->
            <div v-if="isTyping" class="flex justify-start">
                <div class="bg-slate-50 border border-slate-100 rounded-2xl rounded-tl-md px-4 py-3 flex gap-1 items-center">
                    <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay:0ms"></span>
                    <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay:150ms"></span>
                    <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay:300ms"></span>
                </div>
            </div>
        </div>

        <!-- Suggestions -->
        <div class="px-4 pb-2 flex gap-1.5 overflow-x-auto shrink-0 scrollbar-hide">
            <button v-for="pill in suggestionPills" :key="pill.query" @click="sendQuery(pill.query)"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50 text-[11px] font-bold text-slate-600 hover:text-indigo-600 rounded-full transition-all shrink-0 cursor-pointer">
                <span>{{ pill.icon }}</span>
                <span>{{ pill.label }}</span>
            </button>
        </div>

        <!-- Input -->
        <div class="px-4 pb-3 flex gap-2 items-center shrink-0">
            <input v-model="input" @keyup.enter="send" :disabled="isTyping"
                placeholder="Écris un message..."
                class="flex-1 px-3 py-2.5 text-sm font-medium text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-500/10 transition-all outline-none placeholder-slate-400 disabled:opacity-50" />
            <button @click="send" :disabled="isTyping || !input.trim()"
                class="w-9 h-9 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl flex items-center justify-center transition-all shadow-sm shadow-indigo-200 disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5m0 0l-5 5m5-5l5 5"/>
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
            messages: [],
            suggestionPills: [
                { icon: "📅", label: "Planning", query: "planning du jour" },
                { icon: "📊", label: "Moyenne", query: "ma moyenne" },
                { icon: "📝", label: "Notes", query: "mes notes" },
                { icon: "⚠️", label: "Absences", query: "mes absences" },
            ],
        };
    },
    mounted() {
        this.addBotMessage(this.getWelcomeHTML());
    },
    methods: {
        getNow() {
            return new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
        },
        addBotMessage(html) {
            this.messages.push({ from: 'bot', text: html, time: this.getNow() });
            this.scrollToBottom();
        },
        getWelcomeHTML() {
            return `
                <div class="space-y-3">
                    <p class="font-black text-slate-900 text-sm">Bonjour ! 👋</p>
                    <p class="text-[13px] text-slate-600 font-medium leading-relaxed">Je suis ton assistant académique. Comment puis-je t'aider ?</p>
                    <div class="grid grid-cols-2 gap-2 pt-1">
                        <div class="p-2.5 bg-indigo-50 border border-indigo-100 rounded-xl flex items-center gap-2">
                            <span class="text-lg">📅</span>
                            <div><p class="text-[11px] font-black text-indigo-700">Planning</p><p class="text-[10px] text-slate-500 font-semibold">Cours du jour</p></div>
                        </div>
                        <div class="p-2.5 bg-emerald-50 border border-emerald-100 rounded-xl flex items-center gap-2">
                            <span class="text-lg">📝</span>
                            <div><p class="text-[11px] font-black text-emerald-700">Notes</p><p class="text-[10px] text-slate-500 font-semibold">Derniers résultats</p></div>
                        </div>
                        <div class="p-2.5 bg-amber-50 border border-amber-100 rounded-xl flex items-center gap-2">
                            <span class="text-lg">📊</span>
                            <div><p class="text-[11px] font-black text-amber-700">Moyenne</p><p class="text-[10px] text-slate-500 font-semibold">GPA & progrès</p></div>
                        </div>
                        <div class="p-2.5 bg-rose-50 border border-rose-100 rounded-xl flex items-center gap-2">
                            <span class="text-lg">⚠️</span>
                            <div><p class="text-[11px] font-black text-rose-700">Absences</p><p class="text-[10px] text-slate-500 font-semibold">Justifications</p></div>
                        </div>
                    </div>
                </div>`;
        },
        async sendQuery(queryText) {
            this.input = queryText;
            await this.send();
        },
        async send() {
            const text = this.input.trim();
            if (!text || this.isTyping) return;

            this.messages.push({ from: "user", text, time: this.getNow() });
            this.input = "";
            this.isTyping = true;
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

                if (!res.ok) throw new Error(`Erreur ${res.status}`);

                const data = await res.json();
                this.messages.push({ from: "bot", text: data.reply, time: this.getNow() });
            } catch (e) {
                this.messages.push({
                    from: "bot",
                    text: `<div class="flex items-center gap-2 p-2 bg-rose-50 border border-rose-100 rounded-xl"><span>⚠️</span><span class="text-xs font-bold text-rose-600">Erreur : ${e.message}</span></div>`,
                    time: this.getNow(),
                });
            } finally {
                this.isTyping = false;
                this.scrollToBottom();
            }
        },
        resetChat() {
            this.messages = [];
            this.addBotMessage(this.getWelcomeHTML());
        },
        scrollToBottom() {
            this.$nextTick(() => {
                const c = this.$refs.chatContainer;
                if (c) c.scrollTo({ top: c.scrollHeight, behavior: "smooth" });
            });
        },
    },
};
</script>

<style scoped>
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
