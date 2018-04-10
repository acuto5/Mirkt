<template>
    <v-container>
        <v-layout row wrap justify-space-around>
            <!-- Title -->
            <v-flex xs12 mb-2 class="text-xs-center">
                <h2 class="headline">Publikuoti straipsniai</h2>
            </v-flex>

            <!-- Search form -->
            <v-flex xs12 lg10>
                <search-articles-form
                        :title-errors="PublishedArticlesObj.Errors.title"
                        :sub-category-errors="PublishedArticlesObj.Errors.sub_category_id"
                />
            </v-flex>

            <template v-if="showContent">
                <!-- Order by -->
                <v-flex xs12 lg10 my-2>
                    <order-by/>
                </v-flex>

                <!-- Articles table -->
                <v-flex xs12 lg10 class="text-xs-center" v-show="PublishedArticlesObj.Articles.length">
                    <published-articles-table :published-articles-obj="PublishedArticlesObj"/>
                </v-flex>
            </template>

            <!-- Pagination -->
            <v-flex xs12 lg6 my-2 class="text-xs-center">
                <pagination-with-page-query
                        :last-page="PublishedArticlesObj.lastPage"
                        :on-query-change="searchArticles"
                />
            </v-flex>
        </v-layout>

        <!-- Errors -->
        <v-layout row wrap justify-space-around v-if="errorExists()">
            <v-flex xs12 sm10 md8 lg6 xl4>
                <alert-component :messages="PublishedArticlesObj.Errors.order_by" type="error"/>
                <alert-component :messages="PublishedArticlesObj.Errors.page" type="error"/>
            </v-flex>
        </v-layout>

        <!-- Progress circular -->
        <progress-circular v-if="PublishedArticlesObj.isRequestInProgress"/>
    </v-container>
</template>
<script>
	import AlertComponent          from "../../../../../components/alert-component";
	import PaginationWithPageQuery from "../../../../../components/pagination-with-page-query";
	import ProgressCircular        from "../../../../../components/progress-circular";
	import ArticlesListClass       from '../../ArticlesList';
	import OrderBy                 from '../../components/order-by.vue';
	import PublishedArticlesTable  from "../../components/published-articles-table";
	import SearchArticlesForm      from '../../components/search-form.vue';

	export default {
		components: {
			OrderBy,
			SearchArticlesForm,
			AlertComponent,
			ProgressCircular,
			PublishedArticlesTable,
			PaginationWithPageQuery,
		},
		data() {
			return {
				PublishedArticlesObj: new ArticlesListClass(true)
			}
		},
		computed  : {
			showContent () {
				return !this.PublishedArticlesObj.isRequestInProgress && !this.errorExists();
			},

		},
		methods   : {
			searchArticles(SearchFormInputs, page) {
				this.PublishedArticlesObj.searchArticles(SearchFormInputs, page);
			},
			errorExists () {
				return !!this.PublishedArticlesObj.Errors.page.length || !!this.PublishedArticlesObj.Errors.order_by.length;
			}
		}
	}
</script>  