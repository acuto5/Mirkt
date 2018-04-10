import {getAllTagsPromise} from "../../../marking/tags/Tags";
import {getSubCategoriesWithCategoryAsHeader} from "../../../marking/categories/Categories";


//------------------------------------
// Private vars
//------------------------------------
// Post/Save new Article Form data
const $_FormData = Symbol();

// Errors
const $_FlashMessages = Symbol();

// Router
const $_Router = Symbol();

// Urls
const $_postArticleURL = Symbol();
const $_markAsPublishedURL = Symbol();


//------------------------------------
// Buttons visibility
//------------------------------------
const $_enableButtons = function () {
	this.isButtonsDisabled = false;
};

const $_disableButtons = function () {
	this.isButtonsDisabled = true;
};

//------------------------------------
// Publish new Article
//------------------------------------
const $_goToArticle = function (articleID) {
	return this[$_Router].push({name: 'articles.single', params: {id: articleID}});
};

//------------------------------------
// Generate FormData
//------------------------------------
const $_generateFormData = function () {

	// Clear old data
	this[$_FormData] = new FormData();

	for (let key in this.NewArticleInputs) {
		if (key === 'images') {
			for (let image in this.NewArticleInputs.images) {
				this[$_FormData].append('images[]', this.NewArticleInputs.images[image])
			}
		} else if (key === 'default_image_id') {
			if (this.NewArticleInputs.default_image_id !== null) {
				this[$_FormData].append(key, this.NewArticleInputs[key]);
			}
		} else if (key === 'tags_ids') {
			this.NewArticleInputs.tags_ids.forEach(tag_id => this[$_FormData].append('tags_ids[]', tag_id));
		} else {
			// add other fields
			this[$_FormData].append(key, this.NewArticleInputs[key]);
		}
	}
};

//------------------------------------
// Mark new article as draft
//------------------------------------
const $_markAsPublish = function (articleID) {
	$_clearErrors.call(this);
	$_disableButtons.call(this);

	// Reduce possibility for double click
	if (this.isButtonsDisabled) {
		axios.patch(this[$_markAsPublishedURL], {id: articleID})
			.then(response => $_goToArticle.call(this, articleID))
			.catch(error => $_setErrors.call(this, error));
	}
};

//------------------------------------
// Errors
//------------------------------------
const $_setErrors = function (error) {
	$_enableButtons.call(this);
	this.Errors.setLarevelErrors(error);
	this[$_FlashMessages].setError(error.response.data.message);
};

const $_clearErrors = function () {
	this.Errors.clear();
	this[$_FlashMessages].clear();
};

class NewArticle {
	constructor() {

		// Tags
		this.Tags = [];

		// For select input
		this.subCategoriesForSelectInput = [];

		// Buttons visibility
		this.isButtonsDisabled = false;

		// New article inputs
		this[$_FormData] = {};
		this.NewArticleInputs = {
			title: '', content: '', sub_category_id: -1, tags_ids: [], images: [], default_image_id: null, is_default_img_old: 0
		};

		// Router
		this[$_Router] = {};

		// Urls
		this[$_postArticleURL] = window.URLS.postArticle;
		this[$_markAsPublishedURL] = window.URLS.markArticleAsPublished;

		// Errors
		this[$_FlashMessages] = window.FlashMessages;
		this.Errors = new window.Errors({
			title: [],
			sub_category_id: [],
			content: [],
			tags_ids: [],
			images: [],
			default_image_id: []
		});
	}

	//------------------------------------
	// Publish new article
	//------------------------------------
	publishNewArticle() {
		$_clearErrors.call(this);
		$_disableButtons.call(this);
		$_generateFormData.call(this);

		// Check reduce possibility for double click
		if (this.isButtonsDisabled) {
			axios.post(this[$_postArticleURL], this[$_FormData])
				.then(response => $_markAsPublish.call(this, response.data))
				.catch(error => $_setErrors.call(this, error));
		}
	}

	//------------------------------------
	// Save new article as draft
	//------------------------------------
	saveArticleToDraft() {
		$_clearErrors.call(this);
		$_disableButtons.call(this);
		$_generateFormData.call(this);

		// Reduce possibility for double click
		if (this.isButtonsDisabled) {
			axios.post(this[$_postArticleURL], this[$_FormData])
				.then(response => $_goToArticle.call(this, response.data))
				.catch(error => $_setErrors.call(this, error));
		}
	}

	//------------------------------------
	// Sub-categories
	//------------------------------------
	async getSubCategoriesForSelectInput() {
		this.subCategoriesForSelectInput = await getSubCategoriesWithCategoryAsHeader();
	}

	//------------------------------------
	// Tags
	//------------------------------------
	getTags() {
		getAllTagsPromise()
			.then(response => this.Tags = response.data)
			.catch(error => $_setErrors.call(this, error))
	}

	//------------------------------------
	// Router
	//------------------------------------
	setRouterObj(RouterObj) {
		this[$_Router] = RouterObj;
	}
}

export default NewArticle;
