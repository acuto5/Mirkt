import Axios         from 'axios';
import Lodash        from 'lodash';
import Vue           from 'vue';
import VueRouter     from 'vue-router';
import Vuetify       from 'vuetify';
import Errors        from './app/components/errors/errors';
import FlashMessages from './app/components/flash-messages/flash-messages.js';

// Lodash
window._ = Lodash;

// Axios
window.axios = Axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Token
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
	window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
	console.error( 'CSRF token not found.' );
}

// Vue
window.Vue = Vue;
Vue.use(VueRouter);
Vue.use(Vuetify);

// Other staff
window.Errors = Errors;
window.FlashMessages = new FlashMessages();
