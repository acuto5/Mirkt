import NewArticle from "./views/new/index.vue";
import EditArticle from "./views/edit/index.vue";
import SingleArticle from "./views/single/index.vue";
import DraftArticles from "./views/draft-articles/index.vue";
import PublishedArticles from "./views/published-articles/index.vue";

export default [
	{
		name: 'dashboard.articles',
		path: 'articles',
		redirect: {name: 'dashboard.articles.all'},
		component: {template: '<router-view/>'},
		children: [
			{
				name: 'dashboard.articles.all',
				path: 'all',
				component: PublishedArticles,
				meta: {parentName: 'dashboard.articles'}
			},
			{
				name: 'dashboard.articles.add',
				path: 'add',
				component: NewArticle,
				meta: {parentName: 'dashboard.articles'}
			},
			{
				name: 'dashboard.articles.edit',
				path: 'edit/:id',
				component: EditArticle,
				meta: {parentName: 'dashboard.articles'}
			},
			{
				name: 'dashboard.articles.single',
				path: 'single/:id',
				component: SingleArticle,
				meta: {parentName: 'dashboard.articles'}
			},
			{
				name: 'dashboard.articles.draft',
				path: 'drafts',
				component: DraftArticles,
				meta: {parentName: 'dashboard.articles'}
			}
		]
	},

];
