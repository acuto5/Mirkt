<template>
    <v-container>
        <v-layout row wrap justify-space-around>
            <v-flex d-flex xs12 ma-2>
                <simple-search-form input-name="title" :error-messages="Errors.title"/>
            </v-flex>
            <v-flex xs12 v-show="!isSearchInProgress">
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
            <v-flex xs12 v-if="isSearchInProgress" class="text-xs-center">
                <v-progress-circular fill indeterminate color="teal accent-2" :width="4" :size="50" />
            </v-flex>
            <v-flex xs10 class="text-xs-center">
                <pagination-with-page-query
                        :last-page="lastPage"
                        :on-query-change="searchArticles"
                        v-show="!isSearchInProgress"
                />
                <error-caption-list :error-messages="Errors.page"/>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
	import ArticleCard             from "../../../components/article-card";
	import ErrorCaptionList        from "../../../components/error-caption-list";
	import PaginationWithPageQuery from "../../../components/pagination-with-page-query";
	import SimpleSearchForm        from "../../../components/simple-search-form";
	import {
		getAllPublishedArticlesAxiosRequest,
		searchPublishedArticlesAxiosRequest,
	}                              from "../../../dashboard/articles/ArticlesList";

	export default {
		components: {
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
				Errors            : new window.Errors( {
					title: [],
					page : [],
				} ),
			}
		},
		methods   : {
			searchArticles(query) {
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

				this.isSearchInProgress = false;
			},
			errorSearchArticles ( error ) {
				this.Errors.setLarevelErrors( error );

				this.isSearchInProgress = false;
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