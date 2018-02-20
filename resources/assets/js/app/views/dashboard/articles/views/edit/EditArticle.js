
import { getArticle }                         from "../../../../main/articles/single/SingleArticle";
import {getSubCategoriesWithCategoryAsHeader} from "../../../marking/categories/Categories";
import {getAllTagsPromise}                    from "../../../marking/tags/Tags";

//--------------------------------------
// Private vars
//--------------------------------------
// FormData
const $_FormData = Symbol();

// Router
const $_Router = Symbol();

// Urls
const $_editArticleURL = Symbol();

//--------------------------------------
// Generate form data
//--------------------------------------
const $_generateFormData = function () {
	let vm = this;

	this[$_FormData] = new FormData();

	for (let key in this.EditArticleInputs) {
		if (key === 'images') {
			this.EditArticleInputs.images.forEach(image => this[$_FormData].append('images[]', image));
		} else if (key === 'old_images') {
			_.forEach(this.EditArticleInputs.old_images, function (value) {
				vm[$_FormData].append('old_images_ids[]', value.id);
			});
		} else if (key === 'tags_ids') {
			_.forEach(this.EditArticleInputs.tags_ids, function (value) {
				vm[$_FormData].append('tags_ids[]', value);
			});
		} else{
			vm[$_FormData].append(key, this.EditArticleInputs[key]);
		}
	}

	this[$_FormData].append('_method', 'patch');
};


//--------------------------------------
// Get article
//--------------------------------------
const $_successGetArticle = function (response) {
	this.EditArticleInputs = response.data;
	this.EditArticleInputs.old_images = response.data.images || [];
	this.EditArticleInputs.images = []; // clear images, there will be store new images
	this.EditArticleInputs.default_image_id = null;
	this.EditArticleInputs.is_default_img_old = 0;
	this.EditArticleInputs.tags_ids = this.EditArticleInputs.tags.map(tag => tag.id);

	// add is_removed boolean
	this.EditArticleInputs.old_images.map(image => image.is_removed = false);

	$_enableButtons.call(this);
};

//--------------------------------------
// Buttons
//--------------------------------------
const $_enableButtons = function () {
	this.isButtonsDisabled = false;
};
const $_disableButtons = function () {
	this.isButtonsDisabled = true;
};

//--------------------------------------
// Router
//--------------------------------------

const $_goToArticle = function (articleID) {
	window.FlashMessages.setSuccess('Atnaujinta.');

	this[$_Router].push({name: 'articles.single', params: {id: articleID}});
};

//--------------------------------------
// Errors
//--------------------------------------
const $_setErrors = function (error) {
	this.Errors.setLarevelErrors(error);

	$_enableButtons.call(this);
	this.isRequestInProgress = false;
};

const $_clearErrors = function () {
	this.Errors.clear();
};

class EditArticle {
	constructor() {
		// Tags
		this.Tags = [];

		// Sub-categories for select input
		this.subCategoriesForSelectInput = [];

		// Edit article inputs
		this.EditArticleInputs = {
			sub_category_id: -1,
			images: [],
			old_images: [],
			tags_ids: [],
			default_image_id: null,
			is_default_img_old: 0
		};

		// Router
		this[$_Router] = {};

		// FormData
		this[$_FormData] = {};

		// urls
		this[$_editArticleURL] = window.URLS.editArticle;

		// Buttons visibility
		this.isButtonsDisabled = true;

		this.isRequestInProgress = true;

		// Errors
		this.Errors = new window.Errors({
			title: [],
			sub_category_id: [],
			content: [],
			tags_ids: [],
			images: [],
			old_images_ids: [],
			default_image_id: [],
			is_default_img_old: []
		});
	}

	//--------------------------------------
	// Categories
	//--------------------------------------
	updateArticle() {
		$_clearErrors.call(this);
		$_disableButtons.call(this);

		$_generateFormData.call(this);

		axios.post(this[$_editArticleURL], this[$_FormData])
			.then(response => $_goToArticle.call(this, response.data)) // redirect to article preview
			.catch(error => $_setErrors.call(this, error));
	}

	//--------------------------------------
	// Categories
	//--------------------------------------
	getArticle(articleID) {
		this.isRequestInProgress = true;

		$_clearErrors.call(this);
		$_disableButtons.call(this);

		getArticle(articleID)
			.then(response => $_successGetArticle.call(this, response))
			.catch(error => $_setErrors.call(this, error));
	}

	//--------------------------------------
	// Sub-categories
	//--------------------------------------
	async getSubCategoriesForSelectInput() {
		this.isRequestInProgress = true;

		this.subCategoriesForSelectInput = await getSubCategoriesWithCategoryAsHeader();

		this.isRequestInProgress = false;
	}

	getTags() {
		this.isRequestInProgress = true;

		getAllTagsPromise()
			.then(response => {
				this.Tags = response.data;

				this.isRequestInProgress = false;
			})
			.catch(error => $_setErrors.call(this, error));

	}

	//--------------------------------------
	// Router
	//--------------------------------------
	setRouterObj(router) {
		this[$_Router] = router;
	}
}

export default EditArticle;