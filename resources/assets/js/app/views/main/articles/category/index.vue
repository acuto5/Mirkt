<template>
    <v-container fluid>
        <v-layout row wrap justify-space-around  v-show="!isRequestInProgress && !errorsExists">
            <!-- Category name -->
            <v-flex xs12 md10 ma-2>
                <span class="display-1">{{ getCategoryName }}</span>
            </v-flex>

            <!-- Articles -->
            <v-flex d-flex xs12 md10 >
                <v-layout row wrap>
                    <v-flex xs6 sm4 lg3 pa-2 v-for="(article,index) in Articles" :key="index">
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
                <pagination-with-page-query :last-page="lastPage" :on-query-change="getArticlesFromCategory"/>
            </v-flex>
        </v-layout>

        <!-- Errors alerts -->
        <v-layout row wrap justify-space-around v-if="errorsExists">
            <v-flex xs12 sm10 md8 lg6 xl4>
                <alert-component :messages="Errors.category_name" type="error" />
                <alert-component :messages="Errors.page" type="error" />
            </v-flex>
        </v-layout>

        <!-- Progress circular -->
        <progress-circular v-if="isRequestInProgress"/>
    </v-container>
</template>

<script>
	import AlertComponent          from "../../../components/alert-component";
	import ArticleCard             from "../../../components/article-card";
	import ErrorCaptionList        from "../../../components/error-caption-list";
	import PaginationWithPageQuery from "../../../components/pagination-with-page-query";
	import ProgressCircular        from "../../../components/progress-circular";
	import { getCategoryArticles } from "../../../dashboard/marking/categories/Categories";

	export default {
		components: {
			AlertComponent,
			ProgressCircular,
			ErrorCaptionList,
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
                FlashMessages: window.FlashMessages
			};
		},
        computed: {
			getCategoryName: function(){
				let CategoryName = this.$route.params.categoryName;

				// First letter in upper case
				return CategoryName[0].toUpperCase() + CategoryName.slice(1);
			},
			errorsExists: function () {
                return this.Errors.page.length || this.Errors.category_name.length;
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
				this.FlashMessages.setError(error.response.data.message);
				this.isRequestInProgress = false;

                // Go one page back
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