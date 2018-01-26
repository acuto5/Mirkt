import Home from './home/routes';
import Articles from './articles/routes'; //Articles
import UserRoutes from './user/routes'; // User

let childs = [];

childs = childs.concat(Home);
childs = childs.concat(Articles);
childs = childs.concat(UserRoutes);

export default [
	{
		path: '/',
		component: require('../layouts/main-layout.vue'),
		children: childs
	}
]
