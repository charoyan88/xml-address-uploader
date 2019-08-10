require('./bootstrap');
import 'es6-promise/auto'
import Vue from 'vue'
import VueRouter from 'vue-router'
import Index from './Index'
import router from './router'
import VueGeolocation from 'vue-browser-geolocation';
// Set Vue globally
window.Vue = Vue;
// Set Vue router
Vue.router = router;
Vue.use(VueRouter);
Vue.use(VueGeolocation);
// Load Index
Vue.component('index', Index);

const app = new Vue({
    el: '#app',
    router,
});