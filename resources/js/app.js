
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import 'vuetify/dist/vuetify.min.css';
require('./bootstrap');
import '@mdi/font/css/materialdesignicons.css';

window.Vue = require('vue').default;

window.Vuetify = require('vuetify/dist/vuetify');

import Vuetify from 'vuetify';
Vue.use(Vuetify);

import VueRouter from 'vue-router';
Vue.use(VueRouter);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import Login from './components/Login.vue';

const routesFile = require('./routes.js');

const router = new VueRouter({
  mode: 'history',
  routes: routesFile.routes
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const opts = {
    icons: {
        iconfont: 'mdi'
    }
};

let vuetify = new Vuetify(opts);

const app = new Vue({
    el: '#app',
    vuetify,
    components: {Login},
    router
});