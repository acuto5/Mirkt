<template>
    <v-container>
        <v-layout
                row
                wrap
                :key="catIndex"
                justify-space-around
                v-for="(category,catIndex) in HomeObj.CategoriesWithSubCategoriesAndArticles"
        >
            <!-- Category->sub-category title-->
            <v-flex xs12 v-for="(subCategory,subIndex) in category.sub_categories" :key="subIndex">
                <!-- Breadcrumbs -->
                <v-divider v-if="!(!catIndex && !subIndex)"/>
                <v-breadcrumbs class="mx-2">
                    <v-icon slot="divider">chevron_right</v-icon>
                    <v-breadcrumbs-item :to="getCategoryRouteParams(category)">
                        {{ category.name }}
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-item :to="getSubCategoryRouteParams(category, subCategory)">
                        {{ subCategory.name }}
                    </v-breadcrumbs-item>
                </v-breadcrumbs>

                <!-- Articles -->
                <v-layout row wrap>
                    <v-flex
                            xs4
                            pa-2
                            d-flex
                            v-for="(article,artIndex) in subCategory.latest_six_published_articles"
                            :key="artIndex"
                    >
                        <article-card
                                height="250px"
                                :title="article.title"
                                :article-id="article.id"
                                :bg-image-url="getHeaderImage(article.header_image)"
                        />
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
	import ArticleCard from "../../components/article-card";
	import HomeClass   from './Home';

	export default {
		components: { ArticleCard },
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