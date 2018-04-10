import router from "./app/routes/app-routes";
import VueAnalytics from 'vue-analytics';

Vue.use( VueAnalytics, {
	id    : 'UA-117103989-1',
	router: router,
	checkDuplicatedScript: true
} );
new Vue( {
    el:'#app',
	router: router,
});