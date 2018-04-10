<template>
    <v-container>
        <v-layout row wrap justify-space-around>
            <!-- Title -->
            <v-flex xs12 mb-2 class="text-xs-center">
                <h2 class="headline">Nepublikuoti straipsniai</h2>
            </v-flex>

            <!-- Search form -->
            <v-flex xs12 lg10>
                <search-articles-form
                        :title-errors="DraftArticlesObj.Errors.title"
                        :sub-category-errors="DraftArticlesObj.Errors.sub_category_id"
                />
            </v-flex>
            <template v-if="showContent">
                <!-- Order by -->
                <v-flex xs12 lg10 my-2>
                    <order-by />
                </v-flex>

                <!-- Articles list -->
                <v-flex xs12 lg10 class="text-xs-center" v-show="DraftArticlesObj.Articles.length">
                    <draft-articles-table :draft-articles-obj="DraftArticlesObj"/>
                </v-flex>
            </template>

            <!-- Pagination -->
            <v-flex xs12 lg6 my-2 class="text-xs-center">
                <pagination-with-page-query
                        :last-page="DraftArticlesObj.lastPage"
                        :on-query-change="searchArticles"
                />
            </v-flex>
        </v-layout>

        <!-- Errors -->
        <v-layout row wrap justify-space-around>
            <v-flex xs12 sm10 md8 lg6 xl4>
                <alert-component :messages="DraftArticlesObj.Errors.page" type="error"/>
                <alert-component :messages="DraftArticlesObj.Errors.order_by" type="error"/>
            </v-flex>
        </v-layout>

        <!-- Progress circular -->
        <progress-circular v-if="DraftArticlesObj.isRequestInProgress"/>
    </v-container>
</template>
<script>
	import AlertComponent          from "../../../../../components/alert-component";
	import PaginationWithPageQuery from "../../../../../components/pagination-with-page-query";
	import ProgressCircular        from "../../../../../components/progress-circular";
	import ArticlesListClass       from '../../ArticlesList';
	import DraftArticlesTable      from "../../components/draft-articles-table";
	import OrderBy                 from '../../components/order-by.vue';
	import SearchArticlesForm      from "../../components/search-form";

	export default {
		components: {
			OrderBy,
			AlertComponent,
			ProgressCircular,
			DraftArticlesTable,
			SearchArticlesForm,
			PaginationWithPageQuery,
		},
		data() {
			return {
				DraftArticlesObj: new ArticlesListClass(false)
			}
		},
		computed  : {
			showContent () {
				return !this.DraftArticlesObj.isRequestInProgress && !this.errorExists();
			},
		},
		methods   : {
			searchArticles: function (SearchFormInputs, page) {
				this.DraftArticlesObj.searchArticles(SearchFormInputs, page);
			},
			errorExists () {
				return !!this.DraftArticlesObj.Errors.page.length || !!this.DraftArticlesObj.Errors.order_by.length;
			},
		}
	}
</script>  