function takeTags(Params) {
	const url = window.URLS.takeTags;

	return axios.get(url, {params: Params});
}
function getAllTagsPromise() {
	const url = window.URLS.getAllTags;

	return axios.get(url);
}

//--------------------
// Global vars
//--------------------
// Route
const $_router = Symbol();

// Paginate
const $_nextPage = Symbol();

// Urls
const $_addTagURL = Symbol();
const $_editTagURL = Symbol();
const $_getTagsURL = Symbol();
const $_deleteTagURL = Symbol();

// Errors
const $_FlashMessages = Symbol();

//--------------------
// Search
//--------------------
const $_clearSearchInputs = function () {
	this.searchInput = '';
};

//--------------------
// List
//--------------------
const $_successUpdateList = function (response) {
	if(response.data.current_page > response.data.last_page){
		this.pushToQuery(response.data.last_page);
	} else {
		this.Tags = response.data.data;
		this.lastPage = response.data.last_page;
		this[$_nextPage] = response.data.current_page;
		this.currentPage = response.data.current_page;
	}
};

const $_errorUpdateList = function (error) {
	this.UpdateListErrors.setLarevelErrors(error);
	this[$_FlashMessages].setError(error.response.data.message);
};

//-------------------
// Add tag
//-------------------
const $_successAddTag = function () {
	$_clearSearchInputs.call(this);
	this[$_router].push({query: {page: 1}});
	this[$_FlashMessages].setSuccess('Pridėta.');

	return true;
};

const $_errorAddTag = function (error) {
	this.AddTagErrors.setLarevelErrors(error);
	this[$_FlashMessages].setError(error.response.data.message);

	return false;
};

//-------------------
// Edit tag
//-------------------
const $_successEditTag = function (EditedTag) {
	this.Tags = this.Tags.map(Tag => {
		return (Tag.id === EditedTag.id) ? EditedTag : Tag;
	});

	this[$_FlashMessages].setSuccess('Atnaujinta.');

	return true;
};

const $_errorEditTag = function (error) {
	this.EditErrors.setLarevelErrors(error);

	return false;
};

//-------------------
// Delete tag
//-------------------
const $_successDeletion = function () {
	this.updateList();
	$_clearSearchInputs.call(this);
	this[$_FlashMessages].setMessage('warning', 'Ištrinta.');

	return true;
};

const $_errorDeleteTag = function (error) {
	this.DeleteTagErrors.setLarevelErrors(error);

	return false;
};

//--------------------
// Errors
//--------------------
const $_clearErrors = function () {
	this.EditErrors.clear();
	this.AddTagErrors.clear();
	this.DeleteTagErrors.clear();
	this.UpdateListErrors.clear();
	this[$_FlashMessages].clear();
};

class Tags {
	constructor($router) {
		this.Tags = [];

		// route
		this[$_router] = $router;

		// Search tag
		this.searchInput = '';

		// Paginate
		this.lastPage = 1;
		this[$_nextPage] = 1;
		this.currentPage = 1;

		// Add tag
		this.newTagName = '';

		// Urls
		this[$_addTagURL] = window.URLS.addTag;
		this[$_editTagURL] = window.URLS.editTag;
		this[$_getTagsURL] = window.URLS.getTags;
		this[$_deleteTagURL] = window.URLS.deleteTag;

		// FlashMessages
		this[$_FlashMessages] = window.FlashMessages;

		// Errors
		this.AddTagErrors = new window.Errors({name: []});
		this.UpdateListErrors = new window.Errors({page: [], tag: []});
		this.DeleteTagErrors = new window.Errors({message: '', id: []});
		this.EditErrors = new window.Errors({message: '', id: [], name: []});
	}


	//--------------------
	// Add tag
	//--------------------
	async addTag(name) {
		$_clearErrors.call(this);

		return await axios.post(this[$_addTagURL], {name: name})
			.then(() => $_successAddTag.call(this))
			.catch(error => $_errorAddTag.call(this, error));
	}

	//--------------------
	// Edit tag
	//--------------------
	async editTag(Tag) {
		$_clearErrors.call(this);

		return await axios.patch(this[$_editTagURL], Tag)
			.then(response => $_successEditTag.call(this, Tag))
			.catch(error => $_errorEditTag.call(this, error));
	}


	//--------------------
	// Delete tag
	//--------------------
	async deleteTag(Tag) {
		$_clearErrors.call(this);

		return await axios.delete(this[$_deleteTagURL], {params: {id: Tag.id}})
			.then(response => $_successDeletion.call(this))
			.catch(error => $_errorDeleteTag.call(this, error));
	}


	//--------------------
	// Search
	//--------------------
	searchTags() {
		this[$_router].push({name: 'tags', query: {page:1, searchKey: this.searchInput}});
	}


	//--------------------
	// Pagination
	//--------------------
	goToPage(page = this.currentPage, searchKey = this.searchInput) {
		this[$_nextPage] = page;
		this.updateList(searchKey);
	}

	//--------------------
	// List
	//--------------------
	updateList(searchKey = null) {
		$_clearErrors.call(this);

		axios.get(this[$_getTagsURL], {params: {page: this[$_nextPage], tag: searchKey}})
			.then(response => $_successUpdateList.call(this, response))
			.catch(error => $_errorUpdateList.call(this, error));
	}

	pushToQuery(page, searchKey = this.searchInput){
		if(!!searchKey) {
			this[$_router].push({name: 'tags', query: {page: page, searchKey: searchKey}});
		} else {
			this[$_router].push({name: 'tags', query: {page: page}});
		}
	}
}

export {takeTags, getAllTagsPromise};
export default Tags;