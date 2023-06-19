require('./bootstrap');

import Vue from 'vue';

import router from './router/index.js';

import VueNoty from 'vuejs-noty';
import 'vuejs-noty/dist/vuejs-noty.css';
Vue.use(VueNoty);

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('header-component', require('./components/Header.vue').default);
Vue.component('footer-component', require('./components/Footer.vue').default);

const app = new Vue({
    el: '#app',
    data:{
        title: "Laravel Vue SPA"
    },
    router
});
