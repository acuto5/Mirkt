import Messages from "./app/components/flash-messages/flash-messages";
import router   from "./app/routes/dashboard-routes";
import VueAnalytics from 'vue-analytics';

Vue.use(VueAnalytics, {
	id: 'UA-117103989-1',
	router: router
});
const app = new Vue({
	el: '#app',
	router: router,
	data: {
		messages: new Messages()
	}
});