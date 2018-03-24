import MainLayout from '../components/layouts/main-layout';
import Articles   from './articles/routes';
import Home       from './home/routes';
import Info       from './info/routes';
import UserRoutes from './user/routes';

let childs = [];

childs = childs.concat(Home);
childs = childs.concat(Info);
childs = childs.concat(Articles);
childs = childs.concat(UserRoutes);

export default [
	{
		path     : '/',
		component: MainLayout,
		children : childs,
	}
]
