
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.$ = window.jQuery = require('jquery');

import * as d3 from "d3";
import VeeValidate from 'vee-validate';
import axios from 'axios';

window.d3 = d3;
require('./bootstrap');
require('./main');
// require('./d3js');

axios.defaults.headers.common['Accept'] = 'application/json';

window.Vue = require('vue');
window.Vue.use(VeeValidate);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('tree-map', require('./components/tree/Tree.vue'));
const app = new Vue({
    el: '#app'
});
