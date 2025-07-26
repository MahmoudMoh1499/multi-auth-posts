import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api';
axios.defaults.withCredentials = true;

const adminToken = localStorage.getItem('admin_token');
if (adminToken) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${adminToken}`;
}

const userToken = localStorage.getItem('user_token');
if (userToken) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${userToken}`;
}

const app = createApp(App);

app.use(router);
app.mount('#app');
