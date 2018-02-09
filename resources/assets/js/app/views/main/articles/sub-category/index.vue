<template>
    <v-container>
        <v-layout row wrap justify-space-around>
            <v-flex xs12 ma-2>
                <span class="display-1">{{ getSubCategoryName }}</span>
            </v-flex>
            <v-flex xs12 v-show="!isRequestInProgress">
                <v-layout row wrap>
                    <v-flex d-flex xs4 pa-2 v-for="(article,index) in Articles" :key="index">
                        <article-card
                                height="250px"
                                :title="article.title"
                                :article-id="article.id"
                                :bg-image-url="getHeaderImageUrl(article.header_image)"
                        />
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex xs12 class="text-xs-center" mb-2 v-if="isRequestInProgress">
                <v-progress-circular fill indeterminate color="teal accent-2" :width="4" :size="50" />
            </v-flex>
            <v-flex xs10 class="text-xs-center" my-2>
                <pagination-with-page-query
                        :on-query-change="getArticlesFromSubCategory"
                        :last-page="lastPage"
                        v-show="!isRequestInProgress"
                />
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
	import ArticleCard                      from "../../../components/article-card";
	import PaginationWithPageQuery          from "../../../components/pagination-with-page-query";
	import { getArticlesBySubCategoryName } from "../../../dashboard/marking/sub-categories/SubCategories";

	export default {
		components: {
			ArticleCard,
			PaginationWithPageQuery,
		},
		name      : "sub-category-articles",
		data () {
			return {
				Articles           : [],
				lastPage           : 1,
				isRequestInProgress: true,
				Errors             : new window.Errors( {
					page             : [],
					sub_category_name: [],
				} ),
			};
		},
        computed: {
			getSubCategoryName: function(){
				let subCategoryName = this.$route.params.subCategoryName;

                // First letter in upper case
				return subCategoryName[0].toUpperCase() + subCategoryName.slice(1);
            }
        },
		methods   : {
			getArticlesFromSubCategory ( query ) {
				this.isRequestInProgress = true;

				query.sub_category_name = this.$route.params.subCategoryName;


				getArticlesBySubCategoryName( query )
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
			getHeaderImageUrl(headerImage){
				if(headerImage){
					return headerImage.url || '';
				}

				return '';
			}
		},
	}
</script>