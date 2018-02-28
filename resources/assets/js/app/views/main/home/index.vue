<template>
    <v-container>
        <v-layout
                row
                wrap
                :key="catIndex"
                justify-space-around
                v-show="!HomeObj.isRequestInProgress"
                v-for="(category,catIndex) in HomeObj.CategoriesWithSubCategoriesAndArticles"
        >
            <!-- Category->sub-category title-->
            <v-flex xs12 v-for="(subCategory,subIndex) in category.sub_categories" :key="subIndex">

                <!-- Breadcrumbs -->
                <div v-if="subCategory.latest_eight_published_articles.length" class="ma-2">

                    <!-- Divider -->
                    <v-divider v-if="!(!catIndex && !subIndex)" class="mb-2"/>

                    <!-- Category -->
                    <router-link
                            :to="getCategoryRouteParams(category)"
                            class="router-link teal--text text--accent-2"
                    >
                        {{ category.name }}
                    </router-link>

                    <!-- Right chevron -->
                    <v-icon class="subheading">chevron_right</v-icon>

                    <!-- Sub-category -->
                    <router-link
                            :to="getSubCategoryRouteParams(category, subCategory)"
                            class="router-link white--text "
                    >
                        {{ subCategory.name }}
                    </router-link>
                </div>


                <!-- Articles -->
                <v-layout row wrap>
                    <v-flex
                            pa-2
                            xs6 sm4 lg3
                            v-for="(article,artIndex) in subCategory.latest_eight_published_articles"
                            :key="artIndex"
                    >
                        <article-card
                                :xs-height="100"
                                :title="article.title"
                                :article-id="article.id"
                                :bg-image-url="getHeaderImage(article.header_image)"
                        />
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>

        <!-- Progress circular -->
        <progress-circular v-if="HomeObj.isRequestInProgress"/>
    </v-container>
</template>
<script>
	import ArticleCard      from "../../components/article-card";
	import ProgressCircular from "../../components/progress-circular";
	import HomeClass        from './Home';

	export default {
		components: {
			ProgressCircular,
			ArticleCard,
		},
		name      : 'home',
		data() {
			return {
				HomeObj: new HomeClass(),
			}
		},
		created() {
			this.HomeObj.getCategoriesWithSubCategoriesAndArticles();
		},
		methods   : {
			getSubCategoryRouteParams ( category, subCategory ) {
				return {
					name  : 'articles.subCategoryArticles',
					params: {
						categoryName   : category.name,
						subCategoryName: subCategory.name,
					},
				};
			},
			getCategoryRouteParams ( category ) {
				return {
					name  : 'articles.categoryArticles',
					params: {
						categoryName: category.name,
					},
				};
			},
			getHeaderImage ( headerImage ) {
				if (headerImage) {
					return headerImage.url || '';
				}

				return '';
			},
		}
	}
</script>