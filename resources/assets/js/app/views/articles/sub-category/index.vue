<template>
    <v-container>
        <v-layout row wrap justify-space-around v-show="!isRequestInProgress && !errorExists">
            <!-- Sub category name -->
            <v-flex xs12 ma-2>
                <span class="display-1">{{ getSubCategoryName }}</span>
            </v-flex>

            <!-- Articles -->
            <v-flex xs12>
                <v-layout row wrap>
                    <v-flex  xs6 sm4 lg3 pa-2 v-for="(article,index) in Articles" :key="index">
                        <article-card
                                :xs-height="100"
                                :title="article.title"
                                :article-id="article.id"
                                :bg-image-url="getHeaderImageUrl(article.header_image)"
                        />
                    </v-flex>
                </v-layout>
            </v-flex>

            <!-- Pagination -->
            <v-flex xs10 class="text-xs-center" my-2>
                <pagination-with-page-query :last-page="lastPage" :on-query-change="getArticlesFromSubCategory" />
            </v-flex>
        </v-layout>

        <!-- Errors -->
        <v-layout row wrap justify-space-around>
            <v-flex d-flex xs12 sm10 md8 lg6 xl4>
                <alert-component type="error" :messages="Errors.page"/>
                <alert-component type="error" :messages="Errors.sub_category_name"/>
            </v-flex>
        </v-layout>

        <!-- Progress circular -->
        <progress-circular v-if="isRequestInProgress"/>
    </v-container>
</template>

<script>
	import AlertComponent                   from "../../../components/alert-component";
	import ArticleCard                      from "../../../components/article-card";
	import PaginationWithPageQuery          from "../../../components/pagination-with-page-query";
	import ProgressCircular                 from "../../../components/progress-circular";
	import { getArticlesBySubCategoryName } from "../../dashboard/marking/sub-categories/SubCategories";

	export default {
		components: {
			AlertComponent,
			ProgressCircular,
			ArticleCard,
			PaginationWithPageQuery,
		},
		name      : "sub-category-articles",
		data () {
			return {
				Articles           : [],
				lastPage           : 1,
				isRequestInProgress: true,
				FlashMessages: window.FlashMessages,
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
            },
            errorExists(){
				return this.Errors.page.length || this.Errors.sub_category_name.length;
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
				this.Errors.clear();

				this.isRequestInProgress = false;
			},
			errorGetArticles ( error ) {
				this.Errors.setLarevelErrors( error );
				this.FlashMessages.setError(error.response.data.message);

				this.isRequestInProgress = false;

				setTimeout(() => this.$router.go(-1), 3000);
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