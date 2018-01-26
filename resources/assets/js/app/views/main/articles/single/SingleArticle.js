function getArticle(articleID){
	const url = window.URLS.getArticle;

	return axios.get(url, {params: {id: articleID}});
}

class SingleArticle{
	constructor(articleID){
		this.articleID = articleID;

		this.Article = {title: '', content: '', author: '', tags: [], images: [], }
	}

	getArticle(){
		getArticle(this.articleID)
			.then(response => this.Article = response.data)
			.catch(error => console.error(error));
	}

	getDefaultImg(){
		if (this.Article.images.length) {
			let defaultImageUrl;
			_.forEach(this.Article.images, function (image) {
				if (image.is_default) {
					defaultImageUrl = image.url;
				}
			});
			return defaultImageUrl;
		}
	}
}

export {getArticle};
export default SingleArticle;
