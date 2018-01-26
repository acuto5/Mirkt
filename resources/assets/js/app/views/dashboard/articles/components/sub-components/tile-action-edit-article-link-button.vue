<template>
    <v-list-tile-action>
        <v-btn
                icon
                ripple
                outline
                color="grey lighten-1"
                title="Redaguoti"
                :to="getRouterLinkParamsToEditArticle"
        >
            <v-icon color="warning">edit</v-icon>
        </v-btn>
    </v-list-tile-action>
</template>

<script>
	export default {
		name: "tile-action-edit-article-link-button",
        props: {
			id: {
				type: Number,
                required: true
            }
        },
        computed: {
			getRouterLinkParamsToEditArticle(){
				return {name: 'dashboard.articles.edit', params: {id: this.id}};
			}
        }

	}
</script>