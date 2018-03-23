<template>
    <v-toolbar-items class="ml-3" v-if="$vuetify.breakpoint.smAndUp">
        <!--Articles menu -->
        <v-menu offset-y v-model="isMenuVisible">
            <v-btn flat slot="activator">Straipsniai</v-btn>
            <v-layout>
                <v-flex>
                    <v-list>
                        <!-- Categories -->
                        <v-list-tile
                                v-for="(category,index) in categoriesWithSubCategories"
                                :key="index"
                                :to="getCategoryRouteParams(category)"
                                active-class="teal--text text--accent-2"
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>{{ category.name }}</v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </v-list>
                </v-flex>
                <v-flex>
                    <v-list>
                        <v-list-tile v-for="(category,index) in categoriesWithSubCategories" :key="index" class="remove-left-padding">
                            <v-list-tile-action style="min-width: 0">
                                <v-menu offset-x open-on-hover>
                                    <v-btn
                                            icon
                                            color="white--text"
                                            slot="activator"
                                    >
                                        <v-icon>play_arrow</v-icon>
                                    </v-btn>
                                    <v-list>
                                        <!-- Sub categories -->
                                        <v-list-tile
                                                v-for="(sub_category,index) in category.sub_categories"
                                                :key="index"
                                                :to="getSubCategoryRouteParams(category, sub_category)"
                                                @click.native="isMenuVisible = false"
                                                active-class="teal--text text--accent-2"
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
                </v-flex>
            </v-layout>
        </v-menu>

        <!-- About -->
        <v-menu offset-y >
            <v-btn flat slot="activator">Info</v-btn>
            <v-list>
                <!-- Contacts -->
                <v-list-tile :to="routerLinkToContactsPage">
                    <v-list-tile-title>Kontaktai</v-list-tile-title>
                </v-list-tile>
                <!-- Contacts -->
                <v-list-tile :to="routerLinkToWebsiteInfoPage">
                    <v-list-tile-title>Puslapio informacija</v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-menu>
    </v-toolbar-items>

    <!-- For mobile -->
    <mobile-links-dialog v-else :categories-with-sub-categories="categoriesWithSubCategories"/>
</template>

<script>

	import MobileLinksDialog from "./dialogs/mobileLinksDialog";

	export default {
		components: { MobileLinksDialog },
		name      : "links-toolbar-items",
		data() {
			return {
				isToolbarSideIconVisible   : false,
				isMenuVisible              : false,
				categoriesWithSubCategories: window.CategoriesWithSubCategories,
				routerLinkToContactsPage   : { name: 'contacts' },
				routerLinkToWebsiteInfoPage: { name: 'website-info' },
			}
		},
		methods   : {
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
		}
	}
</script>