<template>
    <v-list-tile-action>
        <v-btn
                icon
                ripple
                outline
                color="grey lighten-1"
                title="Perkelti į juodraštį"
                @click.native="markArticleAsDraft()"
                :loading="PublishedArticlesObj.isButtonsLoadingStyle"
        >
            <v-icon color="error">directions</v-icon>
        </v-btn>
    </v-list-tile-action>
</template>

<script>
	export default {
		name: "tile-action-mark-article-as-draft-button",
        props: {
			id: {
				type: Number,
                required: true
            },
			PublishedArticlesObj: {
				type: Object,
                required: true
            }
        },
        methods: {
			async markArticleAsDraft(){
				let $_result = await this.PublishedArticlesObj.markArticleAsDraft(this.id);

				if($_result){
					let $_query = Object.assign({}, this.$route.query);

					window.FlashMessages.setSuccess('Straipsnis perkeltas į juodraštį');
					this.PublishedArticlesObj.searchArticles($_query);
				}
            }
        }
	}
</script>