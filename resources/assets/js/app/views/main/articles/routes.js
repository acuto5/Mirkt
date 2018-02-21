import CategoryArticles    from './category/index';
import SearchArticles      from './search/index';
import SingleArticle       from './single/index';
import SubCategoryArticles from './sub-category/index';
import TagArticles         from './tag/index';

export default [
	{
		name: 'articles',
		path: 'articles',
		component: {template: '<router-view/>'},
		children: [
			{
				name     : 'articles.single',
				path     : 'single/:id',
				component: SingleArticle,
				meta     : {
					parentName: 'dashboard.articles',
				},
			},
			{
				name     : 'articles.search',
				path     : 'search',
				component: SearchArticles,
			},
			{
				name     : 'articles.categoryArticles',
				path     : ':categoryName',
				component: CategoryArticles,
			},
			{
				name     : 'articles.subCategoryArticles',
				path     : ':categoryName/:subCategoryName',
				component: SubCategoryArticles,
			},
			{
				name     : 'articles.tagArticles',
				path     : '/tag-articles/:tagName',
				component: TagArticles,
			}
		]
	}
]
