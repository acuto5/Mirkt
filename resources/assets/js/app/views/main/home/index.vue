<template>
    <v-container grid-list-lg v-if="HomeObj.CategoriesWithSubCategoriesAndArticles">

        <v-layout row wrap v-for="(category,index) in HomeObj.CategoriesWithSubCategoriesAndArticles" :key="index">

            <!-- Category title-->
            <v-flex d-flex xs12>
                <h4 class="display-1 deep-purple--text text--lighten-4" v-text="category.name"></h4>
            </v-flex>
            <v-flex xs12 v-for="(subCategory,index) in category.sub_categories" :key="index">
                <v-layout row wrap v-if="isSubCategoryHasArticles(subCategory)">
                    <v-flex d-flex xs12 sm8 md9>
                        <v-layout row wrap>
                            <!-- SubCategory title -->
                            <v-flex d-flex xs12>
                                <h6 class="title deep-purple--text text--lighten-2" v-text="subCategory.name"></h6>
                            </v-flex>
                            <v-flex d-flex xs12>
                                <v-layout row wrap>
                                    <v-flex d-flex xs6 md4 v-for="(article,index) in getArticles(subCategory)"
                                            :key="index">
                                        <!-- Article -->
                                        <v-card :to="getArticleLink(article.id)">
                                            <v-card-media
                                                    height="200"
                                                    :src="getDefaultImageUrl(article.images)"
                                            />
                                            <v-card-title primary-title>
                                                    <h2 class="title" v-text="article.title"></h2>
                                            </v-card-title>
                                        </v-card>
                                    </v-flex>
                                </v-layout>
                            </v-flex>
                        </v-layout>
                    </v-flex>
                    <!-- Ads -->
                    <v-flex d-flex xs12 sm4 md3>
                        <v-layout row wrap>
                            <v-flex d-flex xs12>
                                <v-card light>
                                    <v-card-title primary class="title">Reklama</v-card-title>
                                    <v-card-text
                                            v-text="lorem">
                                    </v-card-text>
                                </v-card>
                            </v-flex>
                            <v-flex d-flex xs12 v-if="getArticles(subCategory).length > 3">
                                <v-card light>
                                    <v-card-title primary class="title">Reklama</v-card-title>
                                    <v-card-text
                                            v-text="lorem">
                                    </v-card-text>
                                </v-card>
                            </v-flex>
                        </v-layout>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
	import HomeClass from './Home';

	export default {
		name: 'home',
		data() {
			return {
				HomeObj: new HomeClass(),
				lorem: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam inventore laudantium optio quas quasi\n' +
				'            voluptatem? Ad animi blanditiis esse, eveniet id, inventore ipsum iure molestias mollitia nisi, repudiandae\n' +
				'            ut vel?'
			}
		},
		created() {
			this.HomeObj.getCategoriesWithSubCategoriesAndArticles();
		},
		methods: {
			getArticles(subCategory) {
				return subCategory.latest_six_published_articles;
			},
			getArticleLink(id) {
				return {name: 'articles.single', params: {id: id}};
			},
			getDefaultImageUrl(images) {
				if (images.length) {
					return images[0].url;
				}
			},
			isSubCategoryHasArticles(subCategory) {
				return !!subCategory.latest_six_published_articles.length;
			}
		}
	}
</script>  