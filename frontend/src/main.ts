import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import axios from "axios";

window.axios = axios;
window.axios.defaults.baseURL = import.meta.env.VITE_API_URL;
window.axios.defaults.withCredentials = true;
window.axios.defaults.withXSRFToken = true;

const app = createApp(App)
app.use(createPinia())
app.use(router)

app.mount('#app')
