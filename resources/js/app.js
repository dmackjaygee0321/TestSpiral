require('./bootstrap');

window.Vue = require('vue');
 
import App from './app.vue';
import VueAxios from 'vue-axios';
import axios from 'axios';


Vue.use(VueAxios, axios);


const app = new Vue({
    el: '#app',
    render: h => h(App),
});