import {deleteArticle} from "./views/single/SingleArticle";

function searchPublishedArticlesAxiosRequest(inputs) {
	const url = window.URLS.searchInPublishedArticles;

	return axios.get(url, {params: inputs});
}

function getAllPublishedArticlesAxiosRequest(query) {
	const url = window.URLS.getAllArticles;

	return axios.get(url, {params: query});
}

//--------------------------------
// Private vars
//--------------------------------
// Article type
const $_isArticlesPublished = Symbol();

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
	this.lastPage = response.data.last_page;
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
	constructor(isPublished = true) {
		this[$_isArticlesPublished] = isPublished;

		// Articles
		this.Articles = [];

		// Paginate
		this.lastPage = 0;

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


	//--------------------------------
	// Get published articles
	//--------------------------------
	getAllArticles(QueryValues) {
		$_clearErrors.call(this);

		let url = $_getGetAllArticlesUrl.call(this);

		axios.get(url, {params: QueryValues})
			.then(response => $_successGetArticles.call(this, response))
			.catch(error => $_setErrors.call(this, error));
	}


	//--------------------------------
	// Search articles
	//--------------------------------
	searchArticles(QueryValues) {
		$_clearErrors.call(this);

		if (!QueryValues.title) {
			// if no search inputs
			this.getAllArticles(QueryValues);
		} else {
			let url = $_getSearchArticlesUrl.call(this);

			axios.get(url, {params: QueryValues})
				.then(response => $_successGetArticles.call(this, response))
				.catch(error => $_setErrors.call(this, error));
		}
	}


	//--------------------------------
	// Mark article as draft
	//--------------------------------
	async markArticleAsDraft(articleID) {
		if (this[$_isArticlesPublished]) {
			$_clearErrors.call(this);

			return await axios.patch(this[$_markAsDraftURL], {id: articleID})
				.then(response => true)
				.catch(error => $_setErrors.call(this, error));
		} else {
			console.log('Article is already draft.');
		}
	}


	//--------------------------------
	// Mark article as published
	//--------------------------------
	async markArticleAsPublished(articleID) {
		if (!this[$_isArticlesPublished]) {
			$_clearErrors.call(this);

			return await axios.patch(this[$_markAsPublishedURL], {id: articleID})
				.then(response => true)
				.catch(error => $_setErrors.call(this, error));
		} else {
			console.log('Article is already published.');
		}
	}


	//--------------------------------
	// Delete article
	//--------------------------------
	async deleteArticle(articleID) {
		if (!this[$_isArticlesPublished]) {
			$_clearErrors.call(this);

			return await deleteArticle(articleID)
				.then(response => true)
				.catch(error => $_setErrors.call(this, error));
		} else {
			console.error('Article can be deleted only if article is draft.');
		}
	}
}

export {searchPublishedArticlesAxiosRequest, getAllPublishedArticlesAxiosRequest};
export default ArticlesList;