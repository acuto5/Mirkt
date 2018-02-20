/**
 * Functions for export
 */
function getCategories() {
	const url = window.URLS.getCategories;

	return axios.get(url);
}

function getCategoriesWithSubCategoriesPromise() {
	const url = window.URLS.getCategoriesAndSubCategories;

	return axios.get(url);
}

function getCategoryArticles ( query ) {
	const url = window.URLS.getCategoryArticles;

	return axios.get(url, {params: query});
}

async function getSubCategoriesWithCategoryAsHeader() {
	let formattedArray = [];
	let CategoriesWithSubCategories = await $_getCategoriesWithSubCategories();

	CategoriesWithSubCategories.forEach(Category => formattedArray = formattedArray.concat($_getSubCategoriesWithHeader(Category)));

	return formattedArray;
}

/**
 * Private functions
 */
const $_getCategoriesWithSubCategories = async function() {
	try {
		const response = await getCategoriesWithSubCategoriesPromise();

		return response.data;
	} catch (e) {
		console.error(e);
	}
};

const $_getSubCategoriesWithHeader = function (Category) {
	return [].concat([{header: Category.name}], Category.sub_categories);
};

//-------------------------
// Vars names
//-------------------------
// FlashMessages
const $_FlashMessages = Symbol();

// Urls
const $_levelUpURL = Symbol();
const $_levelDownURL = Symbol();
const $_addCategoryURL = Symbol();
const $_editCategoryURL = Symbol();
const $_deleteCategoryURL = Symbol();


//-------------------------
// Add category
//-------------------------
const $_successAddCategory = function () {
	this.updateCategoriesList();
	this[$_FlashMessages].setSuccess('Pridėta.');

	return true;
};

const $_errorAddCategory = function (error) {
	this.AddCategoryErrors.setLarevelErrors(error);
	this[$_FlashMessages].setError(error.response.data.message);

	return false;
};

//-------------------------
// Edit category
//-------------------------
const $_successEditCategory = function (EditedCategory) {
	this.Categories = this.Categories.map(Category => {
		return (Category.id === EditedCategory.id) ? Object.assign({}, EditedCategory) : Category;
	});

	this[$_FlashMessages].setSuccess('Atnaujinta.');

	return true;
};

const $_errorEditCategory = function (error) {
	this.EditCategoryErrors.setLarevelErrors(error);

	return false;
};

//-------------------------
// Delete category
//-------------------------
const $_successDeleteCategory = function (id) {

	this.Categories = this.Categories.filter(Category => Category.id !== id);

	this[$_FlashMessages].setWarning('Ištrinta.');

	return true;
};

const $_errorDeleteCategory = function (error) {
	this.DeleteCategoryErrors.setLarevelErrors(error);

	return false;
};

//-------------------------
// Level up category
//-------------------------
const $_successLevelUpCategory = function () {
	this.updateCategoriesList();
};

const $_errorLevelUpCategory = function (error) {
	this.LevelUpErrors.setLarevelErrors(error);
	this[$_FlashMessages].setError(error.response.data.message);
};

//-------------------------
// Level down category
//-------------------------
const $_successLevelDownCategory = function () {
	this.updateCategoriesList();
};

const $_errorLevelDownCategory = function (error) {
	this.LevelDownErrors.setLarevelErrors(error);
	this[$_FlashMessages].setError(error.response.data.message);
};

//-------------------------
// Errors
//-------------------------
const $_clearErrors = function () {
	this.LevelUpErrors.clear();
	this.LevelDownErrors.clear();
	this.AddCategoryErrors.clear();
	this.EditCategoryErrors.clear();
	this.DeleteCategoryErrors.clear();
	this[$_FlashMessages].clear();
};

class Categories {
	constructor() {
		this.Categories = [];

		// FlashMessages
		this[$_FlashMessages] = window.FlashMessages;

		// Show progress circle
		this.isRequestInProgress = true;

		// Urls
		this[$_addCategoryURL] = window.URLS.addCategory;
		this[$_levelUpURL] = window.URLS.levelUpCategory;
		this[$_levelDownURL] = window.URLS.levelDownCategory;
		this[$_editCategoryURL] = window.URLS.editCategory;
		this[$_deleteCategoryURL] = window.URLS.deleteCategory;


		// Errors
		this.LevelUpErrors = new window.Errors({id: []});
		this.LevelDownErrors = new window.Errors({id: []});
		this.AddCategoryErrors = new window.Errors({name: []});
		this.EditCategoryErrors = new window.Errors({message: '', id: [], name: []});
		this.DeleteCategoryErrors = new window.Errors({message: '', id: []});
	}

	//-------------------------
	// Categories list
	//-------------------------
	updateCategoriesList() {
		this.isRequestInProgress = true;

		$_clearErrors.call(this);

		getCategories()
			.then(response => {
				this.Categories = response.data;
				this.isRequestInProgress = false;
			})
			.catch(error => {
				this[$_FlashMessages].setError(error.response.data.message);
				this.isRequestInProgress = false;
			});
	}

	//-------------------------
	// Add category
	//-------------------------
	async addCategory(name) {
		$_clearErrors.call(this);

		return await axios.post(this[$_addCategoryURL], {name: name})
			.then(() => $_successAddCategory.call(this))
			.catch(error => $_errorAddCategory.call(this, error));
	}

	//-------------------------
	// Edit category
	//-------------------------
	async editCategory(Category) {
		$_clearErrors.call(this);

		return await axios.patch(this[$_editCategoryURL], Category)
			.then(response => $_successEditCategory.call(this, Category))
			.catch(error => $_errorEditCategory.call(this, error));
	}

	//-------------------------
	// Delete category
	//-------------------------
	async deleteCategory(id) {
		$_clearErrors.call(this);

		return await axios.delete(this[$_deleteCategoryURL], {params: {id: id}})
			.then(response => $_successDeleteCategory.call(this, id))
			.catch(error => $_errorDeleteCategory.call(this, error));
	}


	//-------------------------
	// Level up category
	//-------------------------
	levelUpCategory(id) {
		$_clearErrors.call(this);

		axios.post(this[$_levelUpURL], {'id': id})
			.then(response => $_successLevelUpCategory.call(this))
			.catch(error => $_errorLevelUpCategory.call(this, error));
	}

	//-------------------------
	// Level up category
	//-------------------------
	levelDownCategory(id) {
		$_clearErrors.call(this);

		axios.post(this[$_levelDownURL], {'id': id})
			.then(response => $_successLevelDownCategory.call(this))
			.catch(error => $_errorLevelDownCategory.call(this, error));
	}
}

export {getCategories, getCategoriesWithSubCategoriesPromise, getSubCategoriesWithCategoryAsHeader, getCategoryArticles}
export default Categories;
