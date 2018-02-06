<template>
    <v-container>
        <v-layout row wrap justify-space-around>
            <v-flex d-flex xs10>
                <simple-search-form input-name="title" :error-messages="Errors.title"/>
            </v-flex>
            <v-flex xs10 class="text-xs-center">
                <v-list v-if="!isSearchInProgress">
                    <v-list-tile-title v-for="(article,index) in Articles" :key="index">
                        <v-list-tile-title>{{article.title}}</v-list-tile-title>
                    </v-list-tile-title>
                </v-list>
                <v-progress-circular fill indeterminate color="brown darken-3" :width="4" :size="50" v-else/>
            </v-flex>
            <!--<v-flex xs10></v-flex>-->
            <v-flex d-flex xs10>
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
	import ErrorCaptionList        from "../../../components/error-caption-list";
	import PaginationWithPageQuery from "../../../components/pagination-with-page-query";
	import SimpleSearchForm        from "../../../components/simple-search-form";
	import {
		getAllPublishedArticlesAxiosRequest,
		searchPublishedArticlesAxiosRequest,
	}                              from "../../../dashboard/articles/ArticlesList";

	export default {
		components: {
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
		}
	}
</script>