import VueRouter  from 'vue-router';
import MainRoutes from '../views/routes';

let routes = [];

routes = routes.concat(MainRoutes);

// If user go in undefined page
routes = routes.concat([{path: '*', redirect: {name: 'home'}}]);

export default new VueRouter({
	routes: routes,
	mode: 'history',
	linkActiveClass: 'is-active',
});