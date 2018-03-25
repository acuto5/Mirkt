<template>
    <v-dialog v-model="isVisible">
        <v-toolbar-side-icon class="hidden-sm-and-up" slot="activator"/>
        <v-expansion-panel>
            <v-expansion-panel-content class="grey darken-4" hide-actions>
                <router-link
                        slot="header"
                        :to="{name: 'home'}"
                        style="text-decoration: none;"
                        class="teal--text text--accent-2"
                        @click.native="isVisible = false"
                >Mirkt
                </router-link>
            </v-expansion-panel-content>
            <!-- Articles -->
            <v-expansion-panel-content class="grey darken-4">
                <div slot="header">Straipsniai</div>
                <v-expansion-panel popout>
                    <v-expansion-panel-content
                            :key="index"
                            class="grey darken-2"
                            v-for="(category,index) in categoriesWithSubCategories"
                        >
                            <div slot="header">
                                <router-link
                                        class="white--text"
                                        style="text-decoration: none;"
                                        @click.native="isVisible = false"
                                        :to="getCategoryRouteParams(category)"
                                >
                                    {{category.name}}
                                </router-link>
                            </div>
                            <v-list class="grey darken-1">
                                <!-- Sub categories -->
                                <v-list-tile
                                        exact
                                        :key="index"
                                        @click.native="isVisible = false"
                                        :to="getSubCategoryRouteParams(category, sub_category)"
                                        v-for="(sub_category,index) in category.sub_categories"
                                >
                                    <v-list-tile-content>
                                        <v-list-tile-title>{{ sub_category.name }}</v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>
                            </v-list>
                        </v-expansion-panel-content>
        </v-expansion-panel>
            </v-expansion-panel-content>

            <!-- Info -->
            <v-expansion-panel-content class="grey darken-4">
                <div slot="header">Info</div>
                <v-list class="grey darken-3">

                    <!-- ontacts -->
                    <v-list-tile :to="{name: 'contacts'}" @click.native="isVisible = false">
                        <v-list-tile-content>
                            <v-list-tile-title>Kontaktai</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>

                    <!-- Website-info -->
                    <v-list-tile :to="{ name: 'website-info' }" @click.native="isVisible = false">
                        <v-list-tile-content>
                            <v-list-tile-title>Papildoma informacija</v-list-tile-title>
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