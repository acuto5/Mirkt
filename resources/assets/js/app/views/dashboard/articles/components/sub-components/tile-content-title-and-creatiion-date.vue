<template>
    <v-list-tile-content>
        <!-- Title as link -->
        <v-list-tile-title>
            <router-link
                    tag="span"
                    class="white--text"
                    v-text="title"
                    :to="routerLinkParamsToSingleArticlePage"
            />
        </v-list-tile-title>

        <!-- Article created at -->
        <v-list-tile-sub-title v-text="createdAt"/>
    </v-list-tile-content>

</template>

<script>
	export default {
		name: "tile-content-title-and-creation-date",
		props: {
			id: {
				type: Number,
				required: true
			},
			title: {
				type: String,
				required: true
			},
			createdAt: {
				type: String,
				required: true
			}
		},
		computed: {
			routerLinkParamsToSingleArticlePage() {
				return {name: 'dashboard.articles.single', params: {id: this.id}};
			}
		}
	}
</script>