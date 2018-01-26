import {deleteArticle} from "./views/single/SingleArticle";

//--------------------------------
// Private vars
//--------------------------------
// Route
const $_Route = Symbol();

// Router
const $_Router = Symbol();

const $_isArticlesPublished = Symbol();

// Search articles
const $_SearchInputs = Symbol();

// Errors
const $_FlashMessages = Symbol();

// Urls
const $_markAsDraftURL = Symbol();
const $_getAllDraftArticlesURL = Symbol();
const $_markAsPublishedURL = Symbol();
const $_searchArticlesInDraftURL = Symbol();
const $_getAllPublishedArticlesURL = Symbol();
const $_searchInPublishedArticlesURL = Symbol();

//--------------------------------
// Get articles
//--------------------------------
const $_successGetArticles = function (response) {
	this.Articles = response.data.data;
	$_setPaginationVars.call(this, response.data.current_page, response.data.last_page, this.per_page);
};

//--------------------------------
// Paginate
//--------------------------------
const $_setPaginationVars = function (currentPage, lastPage, perPage) {
	(lastPage < currentPage) ? this.goToPage(lastPage) : false;
	this.currentPage = currentPage;
	this.lastPage = lastPage;
	this.perPage = perPage;
};

const $_getQueryObjFromSearchInputs = function () {
	let array = {};

	_.forOwn(this[$_SearchInputs], function (value, key) {
		if (!!value) {
			Object.assign(array, {[key]: value});
		}
	});

	return array;
};

//--------------------------------
// Urls
//--------------------------------
const $_getGetAllArticlesUrl = function () {
	return (this[$_isArticlesPublished]) ? this[$_getAllPublishedArticlesURL] : this[$_getAllDraftArticlesURL];
};

const $_getSearchArticlesUrl = function () {
	return (this[$_isArticlesPublished]) ? this[$_searchInPublishedArticlesURL] : this[$_searchArticlesInDraftURL];
};

//--------------------------------
// Errors
//--------------------------------
const $_setErrors = function (error) {
	this.Errors.setLarevelErrors(error);
	this[$_FlashMessages].setError(error.response.data.message);

	return false;
};

const $_clearErrors = function () {
	this.Errors.clear();
	this[$_FlashMessages].clear();
};

class ArticlesList {
	constructor($router, $route, isPublished = true) {
		this[$_isArticlesPublished] = isPublished;

		// Articles
		this.Articles = [];

		// Search inputs
		this[$_SearchInputs] = {
			title: $route.query.title,
			order_by: (!!$route.query.title) ? $route.query.title : 'newest',
			sub_category_id: $route.query.sub_category_id
		};

		// Paginate
		this.perPage = 1;
		this.lastPage = 1;
		this.currentPage = 1;

		// Route
		this[$_Route] = $route;

		// Router
		this[$_Router] = $router;

		// Urls
		this[$_markAsDraftURL] = window.URLS.markArticleAsDraft;
		this[$_markAsPublishedURL] = window.URLS.markArticleAsPublished;
		this[$_getAllPublishedArticlesURL] = window.URLS.getAllArticles;
		this[$_getAllDraftArticlesURL] = window.URLS.getAllDraftArticles;
		this[$_searchArticlesInDraftURL] = window.URLS.searchInDraftArticles;
		this[$_searchInPublishedArticlesURL] = window.URLS.searchInPublishedArticles;

		// Errors
		this[$_FlashMessages] = window.FlashMessages;
		this.Errors = new window.Errors({sub_category_id: [], page: [], title: [], order_by: []})
	}

	viewMounted() {
		let $query = {
			page: this[$_Route].query.page,
			title: this[$_Route].query.title,
			order_by: this[$_Route].query.order_by,
			sub_category_id: this[$_Route].query.sub_category_id
		};
		// Check if page is set in query
		if ($query.page) {
			this[$_SearchInputs] = $query;

			this.goToPage($query.page);
		} else {
			this[$_Router].replace({query: {page: 1}});
		}
	}


	//--------------------------------
	// Get published articles
	//--------------------------------
	getAllArticles(page) {
		$_clearErrors.call(this);

		let params = {
			page: page,
			order_by: this[$_SearchInputs].order_by
		};

		let url = $_getGetAllArticlesUrl.call(this);

		axios.get(url, {params: params})
			.then(response => $_successGetArticles.call(this, response))
			.catch(error => $_setErrors.call(this, error));
	}


	//--------------------------------
	// Search articles
	//--------------------------------
	searchArticles(SearchInputs, page = this.currentPage) {
		$_clearErrors.call(this);

		this[$_SearchInputs] = SearchInputs;
		this[$_SearchInputs].page = page;

		if (!this[$_SearchInputs].title && !this[$_SearchInputs].sub_category_id) {
			// if no search inputs
			this.getAllArticles(1);
		} else {
			let url = $_getSearchArticlesUrl.call(this);

			axios.get(url, {params: this[$_SearchInputs]})
				.then(response => $_successGetArticles.call(this, response))
				.catch(error => $_setErrors.call(this, error));
		}
	}


	//--------------------------------
	// Search articles
	//--------------------------------
	goToPage(page) {
		// If search form not empty
		if (!!this[$_SearchInputs].title || !!this[$_SearchInputs].sub_category_id) {
			this.searchArticles(this[$_SearchInputs], page);
		} else {
			this.getAllArticles(page);
		}
	}

	pushToQuery(page = 1, SearchInputs = this[$_SearchInputs]) {
		let $query = {page}; // add page by default

		// Add title
		if (!!SearchInputs.title) {
			$query.title = SearchInputs.title;
			this[$_SearchInputs].title = SearchInputs.title;
		} else {
			this[$_SearchInputs].title = undefined;
		}

		// Add order_by
		if (!!SearchInputs.order_by) {
			$query.order_by = SearchInputs.order_by;
			this[$_SearchInputs].order_by = SearchInputs.order_by;
		}

		// Add sub_category_id
		if (!!SearchInputs.sub_category_id) {
			$query.sub_category_id = SearchInputs.sub_category_id;
			this[$_SearchInputs].sub_category_id = SearchInputs.sub_category_id;
		} else {
			this[$_SearchInputs].sub_category_id = undefined;
		}

		// Push new values
		this[$_Router].push({query: $query});
	}

	//--------------------------------
	// Search articles
	//--------------------------------
	markArticleAsDraft(articleID) {
		if (this[$_isArticlesPublished]) {
			$_clearErrors.call(this);

			axios.patch(this[$_markAsDraftURL], {id: articleID})
				.then(response => this.goToPage(this.currentPage))
				.catch(error => $_setErrors.call(this, error));
		} else {
			console.log('Article is already draft.');
		}
	}

	markArticleAsPublished(articleID) {
		if (!this[$_isArticlesPublished]) {
			$_clearErrors.call(this);

			axios.patch(this[$_markAsPublishedURL], {id: articleID})
				.then(response => this.goToPage(this.currentPage))
				.catch(error => $_setErrors.call(this, error));
		} else {
			console.log('Article is already published.');
		}
	}

	//--------------------------------
	// Articles list order
	//--------------------------------
	changeArticlesOrder(value) {
		// Change order value
		this[$_SearchInputs].order_by = value;

		// Get query obj from search inputs (without empty values)
		let $query = $_getQueryObjFromSearchInputs.call(this);

		// Push values to url (it will trigger watch: "$route" function)
		this.pushToQuery(1, $query);
	}


	//--------------------------------
	// Delete article
	//--------------------------------
	async deleteArticle(articleID) {
		if (!this[$_isArticlesPublished]) {
			$_clearErrors.call(this);

			return await deleteArticle(articleID)
				.then(response => {
					this.goToPage(this.currentPage);
					return true;
				})
				.catch(error => $_setErrors.call(this, error));
		}
	}
}

export default ArticlesList;