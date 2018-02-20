class Messages {
	constructor() {
		this.error = sessionStorage.getItem('errorMessage');
		this.success = sessionStorage.getItem('successMessage');
		this.warning = sessionStorage.getItem('warningMessage');

		sessionStorage.removeItem('errorMessage');
		sessionStorage.removeItem('successMessage');
		sessionStorage.removeItem('warningMessage');
	}

	setMessage(type, message){
		this.clear();
		this['set' + type.toLowerCase().charAt(0).toUpperCase() + type.slice(1)](message);
	}

	setError(message) {
		this.clear();
		this.error = message;
		sessionStorage.setItem('errorMessage', message);
	}

	setSuccess(message) {
		this.clear();
		this.success = message;
		sessionStorage.setItem('successMessage', message);
	}

	setWarning($message){
		this.clear();
		this.warning = $message;
		sessionStorage.setItem('warningMessage', $message);
	}

	removeError() {
		this.error = '';
		sessionStorage.removeItem('errorMessage');
	}

	removeSuccess() {
		this.success = '';
		sessionStorage.removeItem('successMessage');
	}
	removeWarning(){
		this.warning = '';
		sessionStorage.removeItem('warningMessage');
	}

	clear() {
		this.removeError();
		this.removeSuccess();
		this.removeWarning();
	}
}
export default Messages;