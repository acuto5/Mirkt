import {getArticle} from '../../../../main/articles/single/SingleArticle';

function deleteArticle(articleID){
	const url = window.URLS.deleteArticle;

	return axios.delete(url, {params: {id: articleID}});

}

//------------------------
// Private vars
//------------------------

// Errors
const $_FlashMessages = Symbol();

// Urls
const $_markAsDraftURL = Symbol();
const $_markAsPublishedURL = Symbol();

//------------------------
// Get article
//------------------------
const $_successGetArticle = function (response) {
	this.Article = response.data;
};

//------------------------
// Mark publish/draft article
//------------------------
const $_successMarkRequest = function () {
	this.getArticle();
	$_enableMarkButtons.call(this);
};

//------------------------
// Enable/Disable mark buttons
//------------------------
const $_enableMarkButtons = function () {
	this.isMarkButtonDisabled = false;
};
const $_disableMarkButtons = function () {
	this.isMarkButtonDisabled = true;
};

// Errors
const $_setErrors = function (error) {
	$_enableMarkButtons.call(this);
	this.ArticleErrors.setLarevelErrors(error);
	this[$_FlashMessages].setError(error.response.data.message);
};

class SingleArticle {
	constructor(ArticleID) {
		// Article
		this.Article = {id: ArticleID, author: {}, tags: [], images: {}};

		// Is button disabled
		this.isMarkButtonDisabled = false;

		// Vue router link to edit this article
		this.linkToEditThisArticle = {name: 'dashboard.articles.edit', params: {id: this.Article.id}};

		// Urls
		this[$_markAsDraftURL] = window.URLS.markArticleAsDraft;
		this[$_markAsPublishedURL] = window.URLS.markArticleAsPublished;

		// Errors
		this[$_FlashMessages] = window.FlashMessages;
		this.ArticleErrors = new window.Errors({id: []})
	}

	//------------------------
	// Get article
	//------------------------
	getArticle() {
		getArticle(this.Article.id)
			.then(response => $_successGetArticle.call(this, response))
			.catch(error => $_setErrors.call(this, error));
	}

	//------------------------
	// Mark as published
	//------------------------
	markArticleAsPublished() {
		$_disableMarkButtons.call(this);

		// reduce double click chance
		if (this.isMarkButtonDisabled) {
			axios.patch(this[$_markAsPublishedURL], {id: this.Article.id})
				.then(response => $_successMarkRequest.call(this))
				.catch(error => $_setErrors.call(this, error));
		}
	}


	//------------------------
	// Mark as draft
	//------------------------
	markArticleAsDraft() {
		$_disableMarkButtons.call(this);

		// reduce double click chance
		if (this.isMarkButtonDisabled) {
			axios.patch(this[$_markAsDraftURL], {id: this.Article.id})
				.then(response => $_successMarkRequest.call(this))
				.catch(error => $_setErrors.call(this, error));
		}
	}
}

export {deleteArticle};
export default SingleArticle;
