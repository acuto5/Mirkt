<template>
    <v-container fluid>
        <v-layout row wrap justify-space-around>
            <!-- Search form -->
            <v-flex d-flex xs12 md10 mb-2>
                <simple-search-form input-name="title" :error-messages="Errors.title"/>
            </v-flex>

            <!-- Articles -->
            <template v-show="!isSearchInProgress && Articles.length">
                <v-flex d-flex xs12 md10 v-show="!errorsExists">
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
                    <pagination-with-page-query :last-page="lastPage" :on-query-change="searchArticles"/>
                </v-flex>
            </template>

        </v-layout>

        <!-- Errors alerts -->
        <v-layout row wrap justify-space-around v-if="errorsExists">
            <v-flex xs12 sm10 md8 lg6 xl4>
                <alert-component type="error" :messages="Errors.page"/>
            </v-flex>
        </v-layout>

        <!-- Progress circular -->
        <progress-circular v-if="isSearchInProgress"/>
    </v-container>
</template>

<script>
	import AlertComponent          from "../../../components/alert-component";
	import ArticleCard             from "../../../components/article-card";
	import ErrorCaptionList        from "../../../components/errors/error-caption-list";
	import PaginationWithPageQuery from "../../../components/pagination-with-page-query";
	import ProgressCircular        from "../../../components/progress-circular";
	import SimpleSearchForm        from "../../../components/simple-search-form";
	import {
		getAllPublishedArticlesAxiosRequest,
		searchPublishedArticlesAxiosRequest,
	}                              from "../../dashboard/articles/ArticlesList";

	export default {
		components: {
			ProgressCircular,
			AlertComponent,
			ArticleCard,
			ErrorCaptionList,
			SimpleSearchForm,
			PaginationWithPageQuery,
		},
		name      : "search-articles",
		data() {
			return {
				Articles          : [],
				lastPage          : 1,
				isSearchInProgress: false,
				FlashMessages     : window.FlashMessages,
				Errors            : new window.Errors( {
					title: [],
					page : [],
				} ),
			}
		},
		computed  : {
			errorsExists () {
				return this.Errors.title.length || this.Errors.page.length;
			},
		},
		methods   : {
			searchArticles(query) {
				this.Articles = [];
				this.isSearchInProgress = true;

				if (query.title) {
					searchPublishedArticlesAxiosRequest(query)
						.then(response => this.successSearchArticles(response.data))
						.catch( error => this.errorSearchArticles( error ) );
				} else {
					getAllPublishedArticlesAxiosRequest(query)
						.then(response => this.successSearchArticles(response.data))
						.catch( error => this.errorSearchArticles( error ) );
				}

			},
			successSearchArticles(response) {
				// Check if if page exists
				if (response.last_page < response.current_page) {
					this.$router.replace({query: {page: response.last_page, title: this.$route.query.title}});
				} else {
					this.lastPage = response.last_page;
					this.Articles = response.data;
				}

				this.Errors.clear();
				this.FlashMessages.removeError();
				this.isSearchInProgress = false;
			},
			errorSearchArticles ( error ) {
				this.Articles = [];
				this.Errors.setLarevelErrors( error );
				this.FlashMessages.setError( error.response.data.message );

				this.isSearchInProgress = false;

				if (this.Errors.page.length) {
					setTimeout( () => this.$router.go( -1 ), 3000 );
				}
			},
			getHeaderImageUrl(headerImage){
				if(headerImage){
					return headerImage.url || '';
				}

				return '';
			}
		}
	}
</script>