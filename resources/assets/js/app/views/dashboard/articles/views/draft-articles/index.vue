<template>
    <v-container>
        <v-layout row wrap justify-space-around>
            <v-flex xs12 lg10>
                <search-articles-form
                        :title-errors="DraftArticlesObj.Errors.title"
                        :sub-category-errors="DraftArticlesObj.Errors.sub_category_id"
                />
            </v-flex>
            <v-flex xs12 lg10 my-2>
                <order-by />
                <alert-component class="my-2" type="error" :messages="DraftArticlesObj.Errors.order_by"/>
            </v-flex>
            <v-flex xs12 lg10 class="text-xs-center">
                <draft-articles-table
                        :draft-articles-obj="DraftArticlesObj"
                        v-show="!DraftArticlesObj.isRequestInProgress"
                />
                <v-progress-circular
                        fill
                        indeterminate
                        color="teal accent-2"
                        :width="4"
                        :size="50"
                        v-if="DraftArticlesObj.isRequestInProgress"
                />
            </v-flex>
            <v-flex xs12 lg6 my-2 class="text-xs-center">
                <pagination-with-page-query
                        :last-page="DraftArticlesObj.lastPage"
                        :on-query-change="searchArticles"
                        v-show="!DraftArticlesObj.isRequestInProgress"
                />

                <alert-component :messages="DraftArticlesObj.Errors.page" type="error" class="my-2"/>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
	import ArticlesListClass from '../../ArticlesList';
	import OrderBy from '../../components/order-by.vue';
	import SearchArticlesForm from "../../components/search-form";
	import AlertComponent from "../../../../components/alert-component";
	import DraftArticlesTable from "../../components/draft-articles-table";
	import PaginationWithPageQuery from "../../../../components/pagination-with-page-query";

	export default {
		components: {
			PaginationWithPageQuery,
			DraftArticlesTable, AlertComponent, SearchArticlesForm, OrderBy},
		data() {
			return {
				DraftArticlesObj: new ArticlesListClass(false)
			}
		},
		methods: {
			searchArticles: function (SearchFormInputs, page) {
				this.DraftArticlesObj.searchArticles(SearchFormInputs, page);
			}
		}
	}
</script>  