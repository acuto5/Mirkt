<template>
    <v-container>
        <v-layout row wrap justify-space-around>
            <v-flex xs12 lg10>
                <search-articles-form
                        :searchMethod="searchArticles"
                        :title-errors="PublishedArticlesObj.Errors.title"
                        :sub-category-errors="PublishedArticlesObj.Errors.sub_category_id"
                />
            </v-flex>
            <v-flex xs12 lg10 my-2>
                <order-by :onOrderChange="onOrderChange"/>
                <alert-component class="my-2" type="error" :messages="PublishedArticlesObj.Errors.order_by"/>
            </v-flex>
            <v-flex xs12 lg10 class="text-xs-center">
                <published-articles-table :published-articles-obj="PublishedArticlesObj"/>
            </v-flex>
            <v-flex xs12 lg6 my-2 v-if="PublishedArticlesObj.Articles.length" class="text-xs-center">
                <v-pagination
                        v-model="PublishedArticlesObj.currentPage"
                        :length="PublishedArticlesObj.lastPage"/>
                <alert-component :messages="PublishedArticlesObj.Errors.page" type="error" class="my-2" />
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
	import ArticlesListClass from '../../ArticlesList';
	import AlertComponent from "../../../../components/alert-component";
	import OrderBy from '../../components/order-by.vue';
	import SearchArticlesForm from '../../components/search-form.vue';
	import PublishedArticlesTable from "../../components/published-articles-table";

	export default {
		components: {
			PublishedArticlesTable,
			AlertComponent, OrderBy, SearchArticlesForm},
		data() {
			return {
				PublishedArticlesObj: new ArticlesListClass(this.$router, this.$route, true)
			}
		},
		mounted() {
			this.PublishedArticlesObj.viewMounted();
		},
		methods: {
			searchArticles: function (SearchFormInputs) {
				this.PublishedArticlesObj.pushToQuery(1, SearchFormInputs); // show results from first page
			},
			onOrderChange: function (value) {
				this.PublishedArticlesObj.changeArticlesOrder(value);
			}
		},
		watch: {
			'$route'($route) {
				this.PublishedArticlesObj.goToPage($route.query.page);
			},
			'PublishedArticlesObj.currentPage'(newValue) {
				this.PublishedArticlesObj.pushToQuery(newValue);
			}
		}
	}
</script>  