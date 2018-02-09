<template>
    <v-container>
        <v-layout row wrap justify-space-around>
            <v-flex xs12 ma-2>
                <span class="display-1">{{ getCategoryName }}</span>
            </v-flex>
            <v-flex xs12 v-show="!isRequestInProgress">
                <v-layout row wrap>
                    <v-flex d-flex xs4 pa-1 v-for="(article,index) in Articles" :key="index">
                        <article-card
                                height="250px"
                                :title="article.title"
                                :article-id="article.id"
                                :bg-image-url="getHeaderImageUrl(article.header_image)"
                        />
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex xs10 class="text-xs-center" mb-2 v-if="isRequestInProgress">
                <v-progress-circular
                        fill
                        indeterminate
                        color="teal accent-2"
                        :width="4"
                        :size="50"
                />
            </v-flex>
            <v-flex xs10 class="text-xs-center" my-2>
                <pagination-with-page-query
                        :on-query-change="getArticlesFromCategory"
                        :last-page="lastPage"
                        v-show="!isRequestInProgress && Articles.length > 1"
                />
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
	import ArticleCard             from "../../../components/article-card";
	import PaginationWithPageQuery from "../../../components/pagination-with-page-query";
	import { getCategoryArticles } from "../../../dashboard/marking/categories/Categories";

	export default {
		components: {
			ArticleCard,
			PaginationWithPageQuery,
		},
		name      : "category-articles",
		data () {
			return {
				Articles           : [],
				lastPage           : 1,
				isRequestInProgress: true,
				Errors             : new window.Errors( {
					page         : [],
					category_name: [],
				} ),
			};
		},
        computed: {
			getCategoryName: function(){
				let CategoryName = this.$route.params.categoryName;

				// First letter in upper case
				return CategoryName[0].toUpperCase() + CategoryName.slice(1);
			}
        },
		methods   : {
			getArticlesFromCategory ( query ) {
				this.isRequestInProgress = true;
				query.category_name = this.$route.params.categoryName;

				getCategoryArticles( query )
					.then( response => this.successGetArticles( response ) )
					.catch( error => this.errorGetArticles( error ) );
			},
			successGetArticles ( response ) {
				this.Articles = response.data.data;
				this.lastPage = response.data.last_page;

				this.isRequestInProgress = false;
			},
			errorGetArticles ( error ) {
				this.Errors.setLarevelErrors( error );
				this.isRequestInProgress = false;
			},
			getArticleRouteParams ( articleID ) {
				return {
					name  : 'articles.single',
					params: { id: articleID },
				};
			},
			getHeaderImageUrl(headerImage){
				if(headerImage){
					return headerImage.url || '';
                }

				return '';
            }
		},
	}
</script>