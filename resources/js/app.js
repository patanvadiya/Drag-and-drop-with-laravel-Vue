import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router/route.js';

const app = createApp(App);
app.use(router)
app.mount('#app');
