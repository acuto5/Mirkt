<template>
    <v-list-tile-action>
        <v-btn
                icon
                ripple
                outline
                color="grey lighten-1"
                title="Paskelpti straipsni"
                @click.native="markArticleAsPublish()"
                :loading="DraftArticlesObj.isButtonsLoadingStyle"
        >
            <v-icon color="success">check</v-icon>
        </v-btn>
    </v-list-tile-action>
</template>

<script>
	export default {
		name: "tile-action-mark-article-as-published-button-link",
        props: {
			id: {
				type: Number,
                required: true
            },
			DraftArticlesObj: {
				type: Object,
                required: true
            }
        },
        methods:{
			async markArticleAsPublish(){
				let $_result = await this.DraftArticlesObj.markArticleAsPublished(this.id);

				if($_result){
					let $_query = Object.assign({}, this.$route.query);

					window.FlashMessages.setSuccess('Straipsnis paskelbtas.');
					this.DraftArticlesObj.searchArticles($_query);
                }
            }
        }
	}
</script>