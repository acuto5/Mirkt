<template>
    <v-container fluid>
        <v-layout row wrap justify-space-around>
            <!-- Search bar -->
            <v-flex d-flex xs10 class="text-xs-center">
                <simple-search-form input-name="tag" :error-messages="TagsObj.UpdateListErrors.tag"/>
            </v-flex>

            <!-- Tags table -->
            <v-flex d-flex xs10 class="text-xs-center my-2">
                <tags-table :tags-obj="TagsObj" v-show="!TagsObj.isRequestInProgress"/>

                <v-progress-circular
                        fill
                        indeterminate
                        color="teal accent-2"
                        :width="4"
                        :size="50"
                        v-if="TagsObj.isRequestInProgress"
                />
            </v-flex>

            <!-- Add new tag -->
            <v-flex d-flex xs10 sm8 md6 lg4>
                <add-tag-dialog-form :tags-obj="TagsObj" v-show="!TagsObj.isRequestInProgress"/>
            </v-flex>

            <!-- Pagination -->
            <v-flex xs12 lg10 my-2 class="text-xs-center">
                <pagination-with-page-query
                        :on-query-change="searchTags"
                        :last-page="TagsObj.lastPage"
                        v-show="!TagsObj.isRequestInProgress"
                />
                <error-caption-list :error-messages="TagsObj.UpdateListErrors.page" />
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
	import AlertComponent          from "../../../components/alert-component";
	import ErrorCaptionList        from "../../../components/error-caption-list";
	import PaginationWithPageQuery from "../../../components/pagination-with-page-query";
	import SimpleSearchForm        from "../../../components/simple-search-form";
	import AddTagDialogForm        from "./components/add-tag-dialog-form";
	import TagsTable               from "./components/tags-table";
	import Tags                    from './Tags';

	export default {
		components: {
			ErrorCaptionList,
			AlertComponent,
			SimpleSearchForm,
			PaginationWithPageQuery,
			AddTagDialogForm,
			TagsTable
		},
		data() {
			return {
				TagsObj: new Tags(this.$router, this.$route)
			}
		},
		methods   : {
			searchTags(Query, page) {
				this.TagsObj.updateList(Query.tag, page);
			}
		}
	}
</script>  