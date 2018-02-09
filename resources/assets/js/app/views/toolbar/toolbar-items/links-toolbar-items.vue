<template>
    <v-toolbar-items class="ml-3">
        <!-- Articles menu -->
        <v-menu offset-y v-model="isMenuVisible">
            <v-btn flat slot="activator">Straipsniai</v-btn>
            <v-list dark>
                <!-- Categories -->
                <v-list-tile
                        v-for="(category,index) in categoriesWithSubCategories"
                        :key="index"
                        :to="getCategoryRouteParams(category)"
                        exact
                >
                    <v-list-tile-content>
                        <v-list-tile-title>{{ category.name }}</v-list-tile-title>
                    </v-list-tile-content>
                    <v-list-tile-action>
                        <v-menu offset-x open-on-hover>
                            <v-btn icon color="white--text" slot="activator">
                                <v-icon>play_arrow</v-icon>
                            </v-btn>
                            <v-list dark>
                                <!-- Sub categories -->
                                <v-list-tile
                                        v-for="(sub_category,index) in category.sub_categories"
                                        :key="index"
                                        :to="getSubCategoryRouteParams(category, sub_category)"
                                        exact
                                        @click.native="isMenuVisible = false"
                                >
                                    <v-list-tile-content>
                                        <v-list-tile-title>{{ sub_category.name }}</v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>
                            </v-list>
                        </v-menu>
                    </v-list-tile-action>
                </v-list-tile>
            </v-list>
        </v-menu>

        <!-- About me -->
        <v-menu offset-y>
            <v-btn flat slot="activator">Apie mane</v-btn>
            <v-list dark>
                <!-- Link to GitHub-->
                <v-list-tile :href="linkToMyGitHub">
                    <v-list-tile-title>GitHub</v-list-tile-title>
                </v-list-tile>
                <!-- Contacts -->
                <v-list-tile :to="routerLinkToContactsPage">
                    <v-list-tile-title>Kontaktai</v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-menu>
    </v-toolbar-items>
</template>

<script>

	export default {
		name: "links-toolbar-items",
		data() {
			return {
				isMenuVisible              : false,
				categoriesWithSubCategories: window.CategoriesWithSubCategories,
				linkToMyGitHub             : 'https://github.com/TSmulkys',
				routerLinkToContactsPage   : { name: 'contacts' },
			}
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
            }
		}
	}
</script>