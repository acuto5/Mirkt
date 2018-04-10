<template>
    <v-list-tile-content>
            <router-link  class="router-link white--text" :to="routerLinkParamsToSingleArticlePage">
                <!-- Title as link -->
                <v-list-tile-title>
                    <span v-text="title"></span>
                </v-list-tile-title>

                <!-- Article created at -->
                <v-list-tile-sub-title v-text="createdAt"/>
            </router-link>
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
				return {name: 'articles.single', params: {id: this.id}};
			}
		}
	}
</script>