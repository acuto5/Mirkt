import Tags from "./tags/index.vue";
import Categories from "./categories/index.vue";
import SubCategories from "./sub-categories/index.vue";

export default [
	{
		name: 'dashboard.marking',
		path: 'marking',
		redirect: {name: 'categories'},
		component: {template: '<router-view />'},
		children: [
			{
				name: 'categories',
				path: 'categories',
				component: Categories,
				meta: {
					parentName: 'dashboard.marking'
				}
			},
			{
				name: 'sub-categories',
				path: 'sub-categories',
				component: SubCategories,
				meta: {
					parentName: 'dashboard.marking'
				}
			},
			{
				name: 'tags',
				path: 'tags',
				component: Tags,
				meta: {
					parentName: 'dashboard.marking'
				}
			}
		]
	}
];
