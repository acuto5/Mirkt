import Messages from "./app/components/flash-messages/flash-messages";
import router   from "./routes/dashboard-routes";


const app = new Vue({
	el: '#app',
	router: router,
	data: {
		messages: new Messages()
	}
});