<template>
    <v-container fluid>
        <v-layout row wrap justify-space-around>
            <!-- Search bar -->
            <v-flex d-flex xs10 class="text-xs-center">
                <search-tags-form :tags-obj="TagsObj"/>
            </v-flex>

            <!-- Tags table -->
            <v-flex d-flex xs10 class="text-xs-center my-2">
                <tags-table :tags-obj="TagsObj"/>
            </v-flex>

            <!-- Add new tag -->
            <v-flex d-flex xs10 sm8 md6 lg4 >
                <add-tag-dialog-form :tags-obj="TagsObj"/>
            </v-flex>

            <!-- Pagination -->
            <v-flex xs12 lg10 my-2 class="text-xs-center">
                <v-pagination
                        v-model="TagsObj.currentPage"
                        :length="TagsObj.lastPage"/>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
	import Tags from './Tags';
	import TagsTable from "./components/tags-table";
	import SearchTagsForm from "./components/search-tags-form";
	import AddTagDialogForm from "./components/add-tag-dialog-form";

	export default{
		components: { AddTagDialogForm, TagsTable, SearchTagsForm},
		data(){
			return {
				TagsObj: new Tags(this.$router)
			}
		},
		mounted(){
			let page = (this.$route.query.page) ? this.$route.query.page : undefined;
			let searchKey =  (this.$route.query.searchKey) ? this.$route.query.searchKey : undefined;

			// Add "page" query value if not set
			if(page){
				this.TagsObj.goToPage(page, searchKey);
			} else {
				this.$router.replace({name: 'tags', query: {page: 1}}); // Bug, cant replace/push two query params...
			}
		},
		watch: {
			'$route': function ($route) {
				this.TagsObj.goToPage($route.query.page, $route.query.searchKey);
			},
            'TagsObj.currentPage': function (newValue) {
				this.TagsObj.pushToQuery(newValue);
			}
		}
	}
</script>  