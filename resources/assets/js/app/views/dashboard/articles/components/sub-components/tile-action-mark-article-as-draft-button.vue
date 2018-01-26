<template>
    <v-list-tile-action>
        <v-btn
                icon
                ripple
                outline
                color="grey lighten-1"
                title="Perkelti į juodraštį"
                @click.native="markArticleAsDraft()"
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
			markArticleAsDraft(){
				this.PublishedArticlesObj.markArticleAsDraft(this.id)
            }
        }
	}
</script>

<style scoped>

</style>