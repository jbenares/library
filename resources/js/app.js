import './bootstrap';
import '../css/app.css'; 
import jQuery from 'jquery'; 
window.$ = window.jQuery = jQuery;

import { createApp } from 'vue'

import app from './Components/app.vue'
import router from './router/index.js'
import { TailwindPagination } from 'laravel-vue-pagination';
createApp(app).use(router).component('TailwindPagination',TailwindPagination).mount("#app")
//createApp(app).use(router).mount("#app")