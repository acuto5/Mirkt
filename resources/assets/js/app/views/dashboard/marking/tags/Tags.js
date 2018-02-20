function getAllTagsPromise() {
	const url = window.URLS.getAllTags;

	return axios.get(url);
}

//--------------------
// Global vars
//--------------------

// Urls
const $_addTagURL = Symbol();
const $_editTagURL = Symbol();
const $_getTagsURL = Symbol();
const $_deleteTagURL = Symbol();

//--------------------
// List
//--------------------
const $_successGetTags = function (response) {
	this.Tags = response.data.data;
	this.lastPage = response.data.last_page;

	this.isRequestInProgress = false;
};

const $_errorGetTags = function (error) {
	this.UpdateListErrors.setLarevelErrors(error);

	this.isRequestInProgress = false;
};

//-------------------
// Add tag
//-------------------
const $_successAddTag = function () {
	this.getTags('', 1);
	window.FlashMessages.setSuccess('Pridėta.');

	return true;
};

const $_errorAddTag = function (error) {
	this.AddTagErrors.setLarevelErrors(error);

	return false;
};

//-------------------
// Edit tag
//-------------------
const $_successEditTag = function (EditedTag) {
	this.Tags = this.Tags.map(Tag => {
		return (Tag.id === EditedTag.id) ? EditedTag : Tag;
	});

	window.FlashMessages.setSuccess('Atnaujinta.');

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
	this.getTags('', 1);
	window.FlashMessages.setWarning('Ištrinta.');

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
};

class Tags {
	constructor() {
		this.Tags = [];

		// Paginate
		this.lastPage = 1;

		// Show progress circle
		this.isRequestInProgress = true;

		// Urls
		this[$_addTagURL] = window.URLS.addTag;
		this[$_editTagURL] = window.URLS.editTag;
		this[$_getTagsURL] = window.URLS.getTags;
		this[$_deleteTagURL] = window.URLS.deleteTag;

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
	// List
	//--------------------
	getTags(searchKey = null, page = 1) {
		this.isRequestInProgress = true;

		$_clearErrors.call(this);

		axios.get(this[$_getTagsURL], {params: {page: page, tag: searchKey}})
			.then(response => $_successGetTags.call(this, response))
			.catch(error => $_errorGetTags.call(this, error));
	}
}

export {getAllTagsPromise};
export default Tags;