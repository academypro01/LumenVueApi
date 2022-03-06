import { createApp } from 'vue'
import App from './App.vue'
import router from './router/index';
// import * as Vue from 'vue';
import axios from 'axios';
import VueAxios from "vue-axios";
import VuePaginate from 'vue-paginate'
axios.defaults.baseURL = 'http://localhost:8000/api/v1/';
axios.defaults.headers.get['Accept'] = 'application/json';
axios.defaults.headers.get['Content-Type'] = 'application/json';

createApp(App)
    .use(VueAxios, axios)
    .use(VuePaginate)
    .use(router)
    .mount('#app')
