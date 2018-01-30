<template>
    <v-container>
        <v-layout row wrap justify-space-around>
            <v-flex xs12 lg10>
                <search-articles-form
                        :searchMethod="searchArticles"
                        :title-errors="DraftArticlesObj.Errors.title"
                        :sub-category-errors="DraftArticlesObj.Errors.sub_category_id"
                />
            </v-flex>
            <v-flex xs12 lg10 my-2>
                <order-by :onOrderChange="onOrderChange"/>
                <alert-component class="my-2" type="error" :messages="DraftArticlesObj.Errors.order_by"/>
            </v-flex>
            <v-flex xs12 lg10 class="text-xs-center">
                <draft-articles-table :draft-articles-obj="DraftArticlesObj"/>
            </v-flex>
            <v-flex xs12 lg6 my-2 v-if="DraftArticlesObj.Articles.length" class="text-xs-center">
                <v-pagination
                        v-model="DraftArticlesObj.currentPage"
                        :length="DraftArticlesObj.lastPage"/>
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

	export default {
		components: {DraftArticlesTable, AlertComponent, SearchArticlesForm, OrderBy},
		data() {
			return {
				DraftArticlesObj: new ArticlesListClass(this.$router, this.$route, false)
			}
		},
		mounted() {
			this.DraftArticlesObj.viewMounted();
		},
		methods: {
			searchArticles: function (SearchFormInputs) {
				this.DraftArticlesObj.pushToQuery(1, SearchFormInputs); // show results from first page
			},
			onOrderChange: function (value) {
				this.DraftArticlesObj.changeArticlesOrder(value);
			}
		},
		watch: {
			'$route.query'($query) {
				this.DraftArticlesObj.goToPage($query.page);
			},
			'DraftArticlesObj.currentPage'(newValue) {
				this.DraftArticlesObj.pushToQuery(newValue);
			}
		}
	}
</script>  