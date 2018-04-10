import DashboardLayout from '../../components/layouts/dashboard-layout';
import ArticlesRoutes  from "./articles/routes"; // Articles
import Info            from './info/routes'; // About
import Markings        from './marking/routes'; // Marking

let childs = [];

// Add routes to dashboard as child routes
childs = childs.concat(Info);
childs = childs.concat(Markings);
childs = childs.concat(ArticlesRoutes);

export default [
	{
		path     : '/dashboard',
		component: DashboardLayout, // Layout
		children : childs,
	}
]
