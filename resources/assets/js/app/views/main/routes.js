import Home from './home/routes';
import Info from './info/routes';
import Articles from './articles/routes';
import UserRoutes from './user/routes';

let childs = [];

childs = childs.concat(Home);
childs = childs.concat(Info);
childs = childs.concat(Articles);
childs = childs.concat(UserRoutes);

export default [
	{
		path: '/',
		component: require('../layouts/main/layout.vue'),
		children: childs
	}
]
