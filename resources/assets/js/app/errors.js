class Errors {
	constructor(data) {
		this.original = data;

		// Decelerate error names
		for (let field in data) {
			this[field] = data[field];
		}

		if(!this.original.message){
			this.message = '';
			this.original.message = this.message;
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

	setLarevelErrors(error, flashErrorMessage = true){
		this.clear();
		console.error(error);
		this.add(error.response.data.errors);
		this.setErrorMessage(error.response.data.message, flashErrorMessage);
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

	setErrorMessage(message, flashErrorMessage){
		if(message.length){
			this.message = message;

			if(flashErrorMessage){
				window.FlashMessages.setError(this.message);
			}
		}
	}

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