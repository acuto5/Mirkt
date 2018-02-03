<template>
    <v-container>
        <v-layout row wrap justify-space-around>
            <v-flex xs10>
                <v-list>
                    <v-list-tile-title v-for="(article,index) in Articles" :key="index">
                        <v-list-tile-title>{{article.title}}</v-list-tile-title>
                    </v-list-tile-title>
                </v-list>
            </v-flex>
            <!--<v-flex xs10></v-flex>-->
            <v-flex d-flex xs10>
                <pagination-with-page-query :last-page="lastPage" :on-query-change="searchArticles" />
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
	import {
		getAllPublishedArticlesAxiosRequest,
		searchPublishedArticlesAxiosRequest
	} from "../../../dashboard/articles/ArticlesList";
	import PaginationWithPageQuery from "../../../components/pagination-with-page-query";

	export default {
		components: {PaginationWithPageQuery},
		name: "search-articles",
		data() {
			return {
				Articles: [],
                lastPage: 1
			}
		},
		methods: {
			searchArticles(query) {
				if (query.title) {
					searchPublishedArticlesAxiosRequest(query)
						.then(response => this.successSearchArticles(response.data))
						.catch(error => console.error(error.message));
				} else {
					getAllPublishedArticlesAxiosRequest(query)
						.then(response => this.successSearchArticles(response.data))
						.catch(error => console.error(error));
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
			}
		}
	}
</script>