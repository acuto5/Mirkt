<template>
    <v-dialog v-model="isVisible">
        <v-toolbar-side-icon class="hidden-sm-and-up" slot="activator"/>
        <v-expansion-panel>
            <v-expansion-panel-content class="grey darken-4" hide-actions>
                <router-link
                        slot="header"
                        :to="{name: 'home'}"
                        class="teal--text text--accent-2"
                        style="text-decoration: none;"
                        @click.native="isVisible = false"
                >Mirkt
                </router-link>
            </v-expansion-panel-content>
            <!-- Articles -->
            <v-expansion-panel-content class="grey darken-4">
                <div slot="header">Straipsniai</div>
                <v-expansion-panel popout>
                        <v-expansion-panel-content  class="grey darken-2"
                                                    v-for="(category,index) in categoriesWithSubCategories"
                                :key="index"
                        >
                            <div slot="header">
                                <router-link
                                        class="white--text"
                                        :to="getCategoryRouteParams(category)"
                                        style="text-decoration: none;"
                                        @click.native="isVisible = false"

                                >
                                    {{category.name}}
                                </router-link>
                            </div>
                            <v-list class="grey darken-1">
                                <!-- Sub categories -->
                                <v-list-tile
                                        v-for="(sub_category,index) in category.sub_categories"
                                        :key="index"
                                        :to="getSubCategoryRouteParams(category, sub_category)"
                                        exact
                                        @click.native="isVisible = false"
                                >
                                    <v-list-tile-content>
                                        <v-list-tile-title>{{ sub_category.name }}</v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>
                            </v-list>
                        </v-expansion-panel-content>
        </v-expansion-panel>
            </v-expansion-panel-content>

            <!-- About me-->
            <v-expansion-panel-content class="grey darken-4">
                <div slot="header">Apie mane</div>
                <v-list class="grey darken-3">

                    <!-- Link to GitHub-->
                    <v-list-tile :href="linkToMyGitHub">
                        <v-list-tile-content>
                        <v-list-tile-title>GitHub</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>

                    <!-- Contacts -->
                    <v-list-tile :to="routerLinkToContactsPage" @click.native="isVisible = false">
                        <v-list-tile-content>
                            <v-list-tile-title class="white--text">Kontaktai</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>

                </v-list>
            </v-expansion-panel-content>
        </v-expansion-panel>
    </v-dialog>
</template>

<script>
	export default {
		name   : "mobile-links-dialog",
		props  : {
			categoriesWithSubCategories: {
				type    : Array,
				required: true,
			},
		},
		data () {
			return {
				isVisible: false,
				linkToMyGitHub             : 'https://github.com/TSmulkys',
				routerLinkToContactsPage   : { name: 'contacts' },
			};
		},
		methods: {
			getCategoryRouteParams ( category ) {
				return {
					name  : 'articles.categoryArticles',
					params: { 'categoryName': category.name.toLowerCase() },
				};
			},
			getSubCategoryRouteParams ( category, subCategory ) {
				return {
					name  : 'articles.subCategoryArticles',
					params: {
						categoryName   : category.name.toLowerCase(),
						subCategoryName: subCategory.name.toLowerCase(),
					},
				};
			},
		},
	};
</script>

<style scoped>

</style>