class Errors {
	constructor(data) {
		this.original = data;

		// Decelerate error names
		for (let field in data) {
			this[field] = data[field];
		}
	}

	/**
	 * Clear all old errors and add new errors(laravel)
	 *
	 * @param errors array/obj
	 */
	set(errors) {
		this.clear();
		this.add(errors);
	};

	setLarevelErrors(error){
		this.clear();
		console.error(error);
		this.add(error.response.data.errors);
		this.add({message: error.response.data.message});
	}

	/**
	 * Add new errors
	 *
	 * @param errors array/obj
	 */
	add(errors) {
		for (let field in errors) {
			this[field] = errors[field];
		}
	};

	/**
	 * Remove all errors
	 */
	clear() {
		for (let field in this.original) {
			this[field] = this.original[field];
		}
	};
}

export default Errors;