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
            <v-flex d-flex xs10 sm8 md6 lg4>
                <add-tag-dialog-form :tags-obj="TagsObj"/>
            </v-flex>

            <!-- Pagination -->
            <v-flex xs12 lg10 my-2 class="text-xs-center">
                <pagination-with-page-query :on-query-change="searchTags" :last-page="TagsObj.lastPage"/>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
	import Tags from './Tags';
	import TagsTable from "./components/tags-table";
	import SearchTagsForm from "./components/search-tags-form";
	import AddTagDialogForm from "./components/add-tag-dialog-form";
	import PaginationWithPageQuery from "../../../components/pagination-with-page-query";

	export default {
		components: {PaginationWithPageQuery, AddTagDialogForm, TagsTable, SearchTagsForm},
		data() {
			return {
				TagsObj: new Tags(this.$router, this.$route)
			}
		},
		methods: {
			searchTags(Query, page) {
				this.TagsObj.updateList(Query.tag, page);
			}
		}
	}
</script>  