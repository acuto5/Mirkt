import SingleArticle from './single/index';
import SearchArticles from  './search/index';

export default [
	{
		name: 'articles',
		path: 'articles',
		component: {template: '<router-view/>'},
		children: [
			{
				name: 'articles.single', path: 'single/:id', component: SingleArticle
			},
			{
				name: 'articles.search', path: 'search', component: SearchArticles
			}
		]
	}
]
