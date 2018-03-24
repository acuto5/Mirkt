<template>
    <v-container>
        <v-layout row wrap >
            <!-- Title -->
            <v-flex xs12 mb-2 class="text-xs-center">
                <h3 class="headline">Žymės</h3>
            </v-flex>

            <!-- Search bar -->
            <v-flex xs12 sm10 offset-sm1 md8 offset-md2 lg6 offset-lg3 mb-2>
                <simple-search-form input-name="tag" :error-messages="TagsObj.UpdateListErrors.tag"/>
            </v-flex>

            <!-- Tags table -->
            <v-flex  xs12 sm10 offset-sm1 md8 offset-md2 lg6 offset-lg3 mb-1 v-show="!TagsObj.isRequestInProgress && !errorExists()">
                <tags-table :tags-obj="TagsObj"/>
            </v-flex>

            <!-- Add new tag -->
            <v-flex d-flex xs12 sm10 offset-sm1 md6 offset-md3 lg4 offset-lg4 v-if="!TagsObj.isRequestInProgress">
                <add-tag-dialog-form :tags-obj="TagsObj"/>
            </v-flex>
        </v-layout>

        <!-- Pagination -->
        <v-layout row wrap justify-center>
            <v-flex xs12 md10 my-2>
                <pagination-with-page-query
                        :on-query-change="getTags"
                        :last-page="TagsObj.lastPage"
                />
            </v-flex>
        </v-layout>

        <!-- Errors -->
        <v-layout row wrap justify-space-around v-if="errorExists()">
            <v-flex xs12 sm10 md8 lg6 xl4>
                <alert-component :messages="TagsObj.UpdateListErrors.page" type="error"/>
            </v-flex>
        </v-layout>

        <!-- Progress circular -->
        <progress-circular v-if="TagsObj.isRequestInProgress"/>
    </v-container>
</template>
<script>
	import AlertComponent          from "../../../../components/alert-component";
	import PaginationWithPageQuery from "../../../../components/pagination-with-page-query";
	import ProgressCircular        from "../../../../components/progress-circular";
	import SimpleSearchForm        from "../../../../components/simple-search-form";
	import AddTagDialogForm        from "./components/add-tag-dialog-form";
	import TagsTable               from "./components/tags-table";
	import Tags                    from './Tags';

	export default {
		components: {
			ProgressCircular,
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
			getTags ( Query, page ) {
				this.TagsObj.getTags( Query.tag, page );
			},
			errorExists () {
				return !!this.TagsObj.UpdateListErrors.page.length;
			},
		}
	}
</script>  