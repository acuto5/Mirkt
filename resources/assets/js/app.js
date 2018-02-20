import router from "./app/routes/app-routes";
import Messages from "./app/flash-messages";

const app = new Vue({
    el:'#app',
	router: router,
});