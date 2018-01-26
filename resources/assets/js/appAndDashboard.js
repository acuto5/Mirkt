import router from "./app/routes/dashboard-routes";
import Messages from "./app/flash-messages";

const app = new Vue({
	el: '#app',
	router: router,
	data: {
		messages: new Messages()
	}
});