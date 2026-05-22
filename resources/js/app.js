import { createApp } from 'vue';
import Chatbot from './components/Chatbot.vue';

const mountEl = document.getElementById('app');
if (mountEl) {
    const app = createApp(Chatbot);
    app.mount(mountEl);
}

