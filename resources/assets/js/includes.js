// Lodash
window._ = require('lodash');


// Axios
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Token
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
	window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
	console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Vue
window.Vue = require('vue');

// Vue-router
import VueRouter from 'vue-router';
Vue.use(VueRouter);

// Vuetify
import Vuetify from 'vuetify';
Vue.use(Vuetify);

import FlashMessages from './app/flash-messages';

import Errors from './app/errors';
window.Errors = Errors;
window.FlashMessages = new FlashMessages();