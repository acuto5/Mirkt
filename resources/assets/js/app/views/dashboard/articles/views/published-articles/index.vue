<template>
    <v-container>
        <v-layout row wrap justify-space-around>
            <v-flex xs12 lg10>
                <search-articles-form
                        :title-errors="PublishedArticlesObj.Errors.title"
                        :sub-category-errors="PublishedArticlesObj.Errors.sub_category_id"
                />
            </v-flex>
            <v-flex xs12 lg10 my-2>
                <order-by/>
                <alert-component class="my-2" type="error" :messages="PublishedArticlesObj.Errors.order_by"/>
            </v-flex>
            <v-flex xs12 lg10 class="text-xs-center">
                <published-articles-table
                        :published-articles-obj="PublishedArticlesObj"
                        v-show="!PublishedArticlesObj.isRequestInProgress"
                />

                <v-progress-circular
                        fill
                        indeterminate
                        color="teal accent-2"
                        :width="4"
                        :size="50"
                        v-if="PublishedArticlesObj.isRequestInProgress"
                />
            </v-flex>
            <v-flex xs12 lg6 my-2 class="text-xs-center">
                <pagination-with-page-query
                        v-show="!PublishedArticlesObj.isRequestInProgress"
                        :last-page="PublishedArticlesObj.lastPage"
                        :on-query-change="searchArticles"
                />
                <alert-component :messages="PublishedArticlesObj.Errors.page" type="error" class="my-2" />
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
	import AlertComponent from "../../../../components/alert-component";
	import PaginationWithPageQuery from "../../../../components/pagination-with-page-query";
	import ArticlesListClass from '../../ArticlesList';
	import OrderBy from '../../components/order-by.vue';
	import PublishedArticlesTable from "../../components/published-articles-table";
	import SearchArticlesForm from '../../components/search-form.vue';

	export default {
		components: {
			PaginationWithPageQuery,
			PublishedArticlesTable,
			AlertComponent, OrderBy, SearchArticlesForm},
		data() {
			return {
				PublishedArticlesObj: new ArticlesListClass(true)
			}
		},
		methods: {
			searchArticles(SearchFormInputs, page) {
				this.PublishedArticlesObj.searchArticles(SearchFormInputs, page);
			}
		}
	}
</script>  