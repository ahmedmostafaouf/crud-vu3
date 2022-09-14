import './bootstrap';
import { createApp } from 'vue';
import app from './Pages/app.vue';
import router from './router/Index.js';
import Pagination from 'v-pagination-3';

createApp(app).use(router).use(Pagination).mount('#app')
