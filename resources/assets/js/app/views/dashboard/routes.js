/**
 * Routes
 */
import Info from './info/routes' // About
import Markings  from './marking/routes'; // Marking
import ArticlesRoutes from "./articles/routes"; // Articles

let childs = [];

// Add routes to dashboard as child routes
childs = childs.concat(Info);
childs = childs.concat(Markings);
childs = childs.concat(ArticlesRoutes);

export default [
	{
		path: '/dashboard',
		component: require('../layouts/dashboard/layout.vue'), // Main layout
		children: childs
	}
]
