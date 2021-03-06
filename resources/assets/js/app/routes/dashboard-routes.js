import VueRouter       from "vue-router";
import DashboardRoutes from '../views/dashboard/routes';
import MainRoutes      from '../views/routes';

let routes = [];

routes = routes.concat(MainRoutes);
routes = routes.concat(DashboardRoutes);

// If user go in undefined page
routes = routes.concat([{path: '*', redirect: {name: 'home'}}]);

export default new VueRouter({
	routes: routes,
	mode: 'history',
	linkActiveClass: 'is-active'
});
