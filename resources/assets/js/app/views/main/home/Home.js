//-------------------------------------
// Private vars
//-------------------------------------
// Urls
const $_getHomeArticlesURL = Symbol();

//-------------------------------------
// Success requests
//-------------------------------------
const $_successRequest = function ( response ) {
	this.CategoriesWithSubCategoriesAndArticles = response.data;
	this.isRequestInProgress = false;
};

//-------------------------------------
// Errors
//-------------------------------------
const $_setErrors = function (error) {
	window.FlashMessages.setError(error.response.data.message);

	this.isRequestInProgress = false;
};


class Home {
	constructor() {
		// Sub-categories with articles
		this.CategoriesWithSubCategoriesAndArticles = {};

		// Urls
		this[$_getHomeArticlesURL] = window.URLS.getCategoriesWithSubCategoriesAndArticles;

		this.isRequestInProgress = true;
	}

	getCategoriesWithSubCategoriesAndArticles() {
		this.isRequestInProgress = true;

		axios.get(this[$_getHomeArticlesURL])
			.then(response => $_successRequest.call(this, response))
			.catch(error => $_setErrors.call(this, error));
	}
}

export default Home;
