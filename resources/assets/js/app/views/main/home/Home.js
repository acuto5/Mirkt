//-------------------------------------
// Private vars
//-------------------------------------
// Urls
const $_getHomeArticlesURL = Symbol();

// Errors
const $_FlashMessages = Symbol();

//-------------------------------------
// Errors
//-------------------------------------
const $_setErrors = function (error) {
	this[$_FlashMessages].setError(error.response.data.message);
};
const $_clearErrors = function () {
	this[$_FlashMessages].clear();
};


class Home {
	constructor() {
		// Sub-categories with articles
		this.CategoriesWithSubCategoriesAndArticles = {};

		// Urls
		this[$_getHomeArticlesURL] = window.URLS.getCategoriesWithSubCategoriesAndArticles;

		// Errors
		this[$_FlashMessages] = window.FlashMessages;
	}

	getCategoriesWithSubCategoriesAndArticles() {
		$_clearErrors.call(this);

		axios.get(this[$_getHomeArticlesURL])
			.then(response => this.CategoriesWithSubCategoriesAndArticles = response.data)
			.catch(error => $_setErrors.call(this, error));
	}
}

export default Home;
