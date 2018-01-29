import Home from './home/routes';
import AboutMe from './about-me/routes';
import Articles from './articles/routes';
import UserRoutes from './user/routes';

let childs = [];

childs = childs.concat(Home);
childs = childs.concat(AboutMe);
childs = childs.concat(Articles);
childs = childs.concat(UserRoutes);

export default [
	{
		path: '/',
		component: require('../layouts/main/layout.vue'),
		children: childs
	}
]
