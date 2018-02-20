import { getCategories } from '../categories/Categories';

function getArticlesBySubCategoryName ( query ) {
	const url = window.URLS.getArticlesBySubCategoryName;

	return axios.get( url, { params: query } );
}

//--------------------------
// Global vars
//--------------------------
// Urls
const $_levelUpURL = Symbol();
const $_levelDownURL = Symbol();
const $_getCategoriesURL = Symbol();
const $_addSubCategoryURL = Symbol();
const $_editSubCategoryURL = Symbol();
const $_getSubCategoriesURL = Symbol();
const $_deleteSubCategoryURL = Symbol();

//--------------------
// Categories
//--------------------
const $_successGetCategories = function (response) {
	this.categories = response.data;

	this.isRequestInProgress = false;
};

const $_errorGetCategories = function (error) {
	window.FlashMessages.setError(error.response.data.message);
};

//--------------------
// Sub-categories list
//--------------------
const $_successUpdateSubCategories = function (response) {
	this.subCategories = response.data;

	this.isRequestInProgress = false;
};

const $_errorUpdateSubCategories = function (error) {
	this.UpdateSubCategoriesErrors.setLarevelErrors(error);

	this.isRequestInProgress = false;
};

//--------------------
// Add sub-category
//--------------------
const $_successAddSubCategory = function () {
	this.updateSubCategoriesList();
	window.FlashMessages.setSuccess('Pridėta.');

	return true;
};

const $_errorAddSubCategory = function (error) {
	this.AddSubCategoryErrors.setLarevelErrors(error);

	return false;
};

//--------------------
// Edit sub-category
//--------------------
const $_successEditSubCategory = function () {
	this.updateSubCategoriesList();
	window.FlashMessages.setSuccess('Atnaujinta.');

	return true;
};

const $_errorEditSubCategory = function (error) {
	this.EditSubCategoryErrors.setLarevelErrors(error);

	return false;
};

//--------------------------
// Delete sub-category
//--------------------------
const $_successDeleteSubCategory = function () {
	this.updateSubCategoriesList();
	window.FlashMessages.setWarning('Ištrinta.');

	return true;
};

const $_errorDeleteSubCategory = function (error) {
	this.DeleteSubCategoryErrors.setLarevelErrors(error);

	return false;
};

//--------------------
// Level down sub-category
//--------------------
const $_errorLevelDown = function (error) {
	this.LevelDownErrors.setLarevelErrors(error);
	window.FlashMessages.setError(error.response.data.message);
};

//--------------------
// Level up sub-category
//--------------------
const $_errorLevelUp = function (error) {
	this.LevelUpErrors.setLarevelErrors(error);
};

//--------------------
// Errors
//--------------------
const $_clearErrors = function () {
	window.FlashMessages.clear();
	this.UpdateSubCategoriesErrors.clear();
};

class SubCategories {
	constructor() {
		// Categories
		this.categories = [];
		this.selectedCategoryID = 0;

		// Sub-categories
		this.subCategories = [];

		// Show progress circle
		this.isRequestInProgress = true;

		// Urls
		this[$_levelUpURL] = window.URLS.levelUpSubCategory;
		this[$_getCategoriesURL] = window.URLS.getCategories;
		this[$_addSubCategoryURL] = window.URLS.addSubCategory;
		this[$_levelDownURL] = window.URLS.levelDownSubCategory;
		this[$_editSubCategoryURL] = window.URLS.editSubCategory;
		this[$_getSubCategoriesURL] = window.URLS.getSubCategories;
		this[$_deleteSubCategoryURL] = window.URLS.deleteSubCategory;

		// Errors
		this.LevelUpErrors = new window.Errors({id: []});
		this.LevelDownErrors = new window.Errors({id: []});
		this.UpdateSubCategoriesErrors = new window.Errors({id: []});
		this.DeleteSubCategoryErrors = new window.Errors({id: [], message: ''});
		this.AddSubCategoryErrors = new window.Errors({name: [], category_id: []});
		this.EditSubCategoryErrors = new window.Errors({message: '', id: [], sub_category_id: [], name: []});
	}

	//--------------------
	// Categories
	//--------------------
	getCategories() {

		$_clearErrors.call(this);

		getCategories()
			.then(response => $_successGetCategories.call(this, response))
			.catch(error => $_errorGetCategories.call(this, error));
	}


	//--------------------
	// Sub-categories list
	//--------------------
	updateSubCategoriesList() {
		this.isRequestInProgress = true;

		$_clearErrors.call(this);

		axios.get(this[$_getSubCategoriesURL], {params: {'id': this.selectedCategoryID}})
			.then(response => $_successUpdateSubCategories.call(this, response))
			.catch(error => $_errorUpdateSubCategories.call(this, error));
	}


	//--------------------
	// Level up sub-category
	//--------------------
	levelUpSubCategory(id) {
		$_clearErrors.call(this);

		axios.post(this[$_levelUpURL], {'id': id})
			.then(response => this.updateSubCategoriesList())
			.catch(error => $_errorLevelUp.call(this, error));
	}


	//--------------------
	// Level down sub-category
	//--------------------
	levelDownSubCategory(id) {
		$_clearErrors.call(this);

		axios.post(this[$_levelDownURL], {'id': id})
			.then(response => this.updateSubCategoriesList())
			.catch(error => $_errorLevelDown.call(this, error));
	}


	//--------------------
	// Add sub-category
	//--------------------
	async addSubCategory(newSubCategoryName) {
		$_clearErrors.call(this);

		const params = {
			name: newSubCategoryName,
			category_id: this.selectedCategoryID
		};

		return await axios.post(this[$_addSubCategoryURL], params)
			.then(response => $_successAddSubCategory.call(this))
			.catch(error => $_errorAddSubCategory.call(this, error));
	}


	//--------------------
	// Edit sub-category
	//--------------------
	async editSubCategory(Category) {
		$_clearErrors.call(this);

		return await axios.patch(this[$_editSubCategoryURL], Category)
			.then(() => $_successEditSubCategory.call(this))
			.catch(error => $_errorEditSubCategory.call(this, error));
	}

	//--------------------
	// Delete sub-category
	//--------------------
	async deleteSubCategory(id) {
		$_clearErrors.call(this);

		return await axios.delete(this[$_deleteSubCategoryURL], {params: {id: id}})
			.then(() => $_successDeleteSubCategory.call(this))
			.catch(error => $_errorDeleteSubCategory.call(this, error));
	}
}

export { getArticlesBySubCategoryName };
export default SubCategories;